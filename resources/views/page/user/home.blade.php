@extends('layouts.app')

@section('title', 'Home Page')

@section('custom_nav_right')
    @include ('components.login_form')
@endsection

@section('content')
    <div class="warn-div">
        <h1> Here Will Get Some Warning</h1>
        <p class="lead">Here will get some warning content.</p>
        <form action="/api/agree" method="POST">
            <input type="submit" name="agree" class="btn btn-success mr-1" value="Agree"> 
            <input type="submit" name="agree" class="btn btn-danger ml-1" value="Disagree">
        </form>
    </div>
@endsection
