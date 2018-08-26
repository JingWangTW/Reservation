@extends('layouts.app')

@section('title', 'Welcome Page')

@section('custom_css')
    .warn-div
    {
        padding: 3rem 1.5rem;
    }
@endsection

@section('content')
    <div class="warn-div">
        <h1> The rule of reservation </h1>
        <p class="lead">
            <ol>
                <li>Applicable object: The account and the password are only for foreign students in this school.</li>
                <li>Please come to the classroom on the time that you reserved.</li>
                <li>If you absent the class twice for no reason, your reservation right will be canceled for two weeks.</li>
                <li> The earliest time for reserving will be two weeks before the class.</li>
                <li>Please fill the question that you want to ask in the blank while making the reservation.</li>
                <li>If you have any question about the class, do not hesitate to send an email to tutor. (email: <a href="mailto:gash10520@gamil.com">gash10520@gmail.com</a>)</li>
                <li>If you have any problem on reservation system, you can send an email to a technician. (email:<a href="mailto:00457008@email.ntou.edu.tw">00457008@email.ntou.edu.tw</a>)</li>
            </ol>
        </p>
        <form action="/api/agree" method="POST">
            <input type="submit" name="agree" class="btn btn-success mr-1" value="Agree"> 
            <input type="submit" name="agree" class="btn btn-danger ml-1" value="Disagree">
        </form>
    </div>
@endsection
