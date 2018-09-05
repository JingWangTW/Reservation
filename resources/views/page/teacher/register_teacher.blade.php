@extends('layouts.teacher')

@section('title', 'Register A New Teacher')

@section('custom_js')
    
    function check () {
        
        if ( $('#name').val().trim().length && $('#email').val().trim().length ) {
            
            return true;
        }
        else {
            $('#WrongInput').show();
            return false;
        }
    }
    
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <form class="col-md-10 col-sm-12 col-12" action="/api/add_teacher" method="POST" onsubmit="return check();">
                <h1 class="text-muted"> Register A New Teacher </h1>
                <span class="text-danger" id="WrongInput" style="display: none"> Name and email can't be blank. </span>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="account">Account</label>
                    <input type="text" class="form-control" id="account" placeholder="Account" name="account" required>
                    <small class="text-danger"> Use for login. Default password would the same as account. </small>
                    <small class="text-danger">  </small>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                    <small class="text-danger"> Email is used for reset password. </small>
                    <small class="text-danger"> Email and account can be different. </small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
