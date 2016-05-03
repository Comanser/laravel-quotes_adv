@extends('layouts.master')

@section('content')
    <div>A list of all quotes:</div>
    <br>
    @foreach ($quotes as $quote)
        <li>{{ $quote->quote }}</li>
    @endforeach
@endsection
