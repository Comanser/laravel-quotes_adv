@extends('layouts.master')

@section('content')
    <div>A list of all authors:</div>
    <br>
    @foreach ($authors as $author)
        <li>{{ $author->name }} ({{ $author->email }})</li>
    @endforeach
@endsection
