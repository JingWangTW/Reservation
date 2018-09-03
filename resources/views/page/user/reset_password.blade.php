@extends('layouts.user')

@section('title', 'Reset Password')

@section('custom_js')

function checkForm() {
    
    if ( $('#password').val() === $('#check').val() ) {
        return true;
    } else {
        $('#hint').text('Two input are not the same.');
        return false;
    }
}
    
@endsection


@section('content')
    <div class="schedule container">
        <h1> Reset Your Password</h1>
        
        <form action="/api/reset_pwd" method="POST" onsubmit="return checkForm();">
            <input style="display: none" value="{{$token}}" name='token'>
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
