<?php

namespace App\Http\Controllers;

use App\Author;
use App\Quote;
use App\AuthorLog;
use Illuminate\Http\Request;
use App\Events\QuoteCreated;
use Illuminate\Support\Facades\Event;

class QuoteController extends Controller
{
    public function getIndex($author = null)
    {
        // Get all quotes (cap at 6, order by created at)
        // If author is provided => Only find quotes by author
        // Possibly paginate
        if (!is_null($author)) {
            $quotes = Author::where('name', $author)->first()->quotes()->orderBy('created_at', 'desc')->paginate(6);
        } else {
            $quotes = Quote::take(6)->orderBy('created_at', 'desc')->paginate(6);
            //$quotes = Quote::orderBy('created_at', 'desc')->paginate(6);
        }
        return view('quotes.index', ['quotes' => $quotes]);
    }

    public function getEdit($quote_id)
    {
        // not implemented
        return view('quotes.edit');
    }

    public function postQuote(Request $request)
    {
        // Check if author and quote text are provided
        $this->validate($request, [
            'author' => 'required|max:60|alpha',
            'quote' => 'required|max:500',
            'email' => 'email'
        ]);
        
        $authorText = ucfirst($request['author']);
        $quoteText = $request['quote'];

        // Check if author already exists in db
        $author = Author::where('name', $authorText)->first();
        if (!$author) {
            $this->validate($request, [
                'email' => 'required|email'
            ]);
            $author = new Author();
            $author->name = $authorText;
            $author->email = $request['email'];
            $author->save();
        } else {
            //&& strlen($request['author']) !== 0
            if (isset($request['emails'])) {
                $author->email = $request['email'];
            }
        }

        // Create quote and map to author
        $quote = new Quote();
        $quote->quote = $quoteText;
        $author->quotes()->save($quote);
        
        Event::fire(new QuoteCreated($author));

        return redirect()->route('index')->with(['success' => 'Quote saved!']);
    }

    public function getDeleteQuote($quote_id)
    {
        // Find quote and delete it
        $quote = Quote::find($quote_id);
        $author_deleted = false;

        // Find author and check if last quote remains
        // and if is the case delete autjor and its log
        if (count($quote->author->quotes) === 1) {
            $author_log = AuthorLog::where('author', $quote->author->name)->first();
            $author_log->delete();
            $quote->author->delete();
            $author_deleted = true;
        }
        $quote->delete();
        
        $msg = $author_deleted ? 'Quote and author deleted!' : 'Quote deleted!';
        return redirect()->route('index')->with(['success' => $msg]);
    }

    public function putQuote(Request $request)
    {
        // Find quote
        // Update info and save
        // not implemented
        return redirect()->route('index')->with(['']);
    }
    
    public function getMailCallback($author_name)
    {
        $author_log = AuthorLog::where('author', $author_name)->first();
        if (!$author_log) {
            $author_log = new AuthorLog();
            $author_log->author = $author_name;
            $author_log->save();
            
            $msg = "Thank you for registering author " . $author_name;
        } else {
            $msg = "Author " . $author_name . " already registered";
        }
        
        return view('email.callback', ['msg' => $msg]);
    }
}