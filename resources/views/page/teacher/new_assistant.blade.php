@extends('layouts.teacher')

@section('title', 'Create Assistant')

@section('content')
    <div class="row justify-content-center">
        <form class="col-lg-8 col-md-10 col-sm-12 col-12" action="/api/add_assistant" method="POST">
            
            <div class="form-group">
                <label for="name">Assistant Name</label>
                <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
                <small class="form-text text-danger">This field would be appear in system as the name of assistant.</small>
            </div>
            <div class="form-group">
                <label for="Student ID">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Email(Account)" name="email" required>
                <small class="form-text text-danger">This would the account for user login.</small>
                <small class="form-text text-danger">Default password would be the same as the account.</small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        
    </div>
@endsection
