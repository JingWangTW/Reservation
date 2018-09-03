@extends('layouts.user')

@section('title', 'Forget Password')

@section('custom_css')

@endsection


@section('content')
    <div class="schedule container">
        <h1> Forget Your Password? </h1>
        <p class="lead"> Please Enter Email Address to Check Your Identity. </p>
        <p class="lead"> After submit, please check your inbox to get following instructions. </p>
        
        <form action="/api/forget_pwd" method="POST">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                <small id="emailHelp" class="form-text text-danger">If you are student, your email must be your {student ID}@mail.ntou.edu.tw</small>
            </div>
            <input type="submit" value="SUBMIT" class="btn btn-primary">
        </form>
        
    </div>
@endsection
