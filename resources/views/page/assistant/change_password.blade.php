@extends('layouts.assistant')

@section('title', 'Change Password')

@section('custom_js')

function checkForm() {
    
    if ( $('#password').val() === $('#check').val() ) {
        return true;
    } else {
        $('#hint').text('Two password are not the same.');
        return false;
    }
}
    
@endsection

@section('content')
    <div class="schedule container">
        <h1> Change Password</h1>
        
        <form action="/api/change_pwd" method="POST" onsubmit="return checkForm();">
            <span class="text-danger" id="hint"></span>
            <div class="form-group">
                <label for="o_password">Origin password</label>
                <input type="password" class="form-control" id="o_password" name="o_password" placeholder="Origin Password" required>
            </div>
            <div class="form-group">
                <label for="password">New password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required>
            </div>
            <div class="form-group">
                <label for="check">Check Again</label>
                <input type="password" class="form-control" id="check" name="check" placeholder="Check" required>
            </div>
            <span class="text-danger" id="hint"></span>
            <input type="submit" value="SUBMIT" class="btn btn-primary">
        </form>
        
    </div>
@endsection
