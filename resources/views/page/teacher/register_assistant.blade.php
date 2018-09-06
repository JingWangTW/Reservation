@extends('layouts.teacher')

@section('title', 'Register A New Assistant')

@section('custom_js')
    
function check () {
    
    $('input').removeClass('is-invalid');
    
    let flag = true;
    
    if ( $('#name').val().trim().length === 0) {
        
        $('#name').addClass('is-invalid');
        
        flag =  false;
        
    }
    
    if ( $('#email').val().trim().length === 0) {
        
        $('#email').addClass('is-invalid');
        
        flag =  false;
        
    }
    
    return flag;
}
    
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <form class="col-md-10 col-sm-12 col-12" action="/api/add_assistant" method="POST" onsubmit="return check();">
                <h1 class="text-muted">Register A New Assistant</h1>
                
                <div class="form-group">
                    <label for="name">Assistant Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
                    <div class="invalid-feedback">
                        Name can't be empty.
                    </div>
                    <small class="form-text text-danger">This field would be appear in system as the name of assistant.</small>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Email(Account)" name="email" required>
                    <div class="invalid-feedback">
                        Email can't be empty.
                    </div>
                    <small class="form-text text-danger">This would the account for user login.</small>
                    <small class="form-text text-danger">Default password would be the same as the account.</small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
