@extends('layouts.master')

@section('content')
    <style type="text/css">
        .input-group label {
            text-align: left;
        }    
    </style>
    @if (count($errors) > 0)
        <div class="info-box fail">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(Session::has('fail'))
        <div class="info-box fail">
            {{ Session::get('fail') }}
        </div>
    @endif
    <form action="{{ route('admin.login') }}" method="post">
        <div class="input-group">
            <label for="name">Admin Name</label>
            <input type="text" id="name" name="name" placeholder="Admin Name">
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password">
        </div>
        <button type="submit" class="btn">Submit</button>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
    </form>
@endsection
