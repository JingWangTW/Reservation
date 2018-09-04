@extends('layouts.teacher')

@section('title', 'Register A New Assistant')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <form class="col-lg-8 col-md-10 col-sm-12 col-12" action="/api/add_assistant" method="POST">
                <h1 class="text-muted">Register A New Assistant</h1>
                <div class="form-group">
                    <label for="name">Assistant Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
                    <small class="form-text text-danger">This field would be appear in system as the name of assistant.</small>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Email(Account)" name="email" required>
                    <small class="form-text text-danger">This would the account for user login.</small>
                    <small class="form-text text-danger">Default password would be the same as the account.</small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection