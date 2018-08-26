@extends('layouts.teacher')

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
        <h1> Here Will Get the Reservation List</h1>
        <p class="lead">Here will get the Reservation List.</p>
        <form action="/api/agree" method="POST">
            <input type="submit" name="agree" class="btn btn-success mr-1" value="Agree"> 
            <input type="submit" name="agree" class="btn btn-danger ml-1" value="Disagree">
        </form>
    </div>
@endsection
