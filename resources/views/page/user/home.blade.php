@extends('layouts.user')

@section('title', 'Home Page')

@section('custom_css')
    .warn-div
    {
        padding: 3rem 1.5rem;
        text-align: center;
    }
@endsection

@section('content')
    <div class="warn-div">
        <h1> Here Will Get Some Schedule here.</h1>
        <p class="lead">Here will get some schedule table.</p>
        
    </div>
@endsection
