@extends('layouts.student')

@section('title', 'Edit Profile')

@section('custom_js')
    
function check () {
    
    $('input').removeClass('is-invalid');
    
    let flag = true;
    
    if ( $('#name').val().trim().length === 0) {
        
        $('#name').addClass('is-invalid');
        
        flag =  false;
        
    }
    
    if ( $('#department').val().trim().length === 0) {
        
        $('#department').addClass('is-invalid');
        
        flag =  false;
        
    }
    
    return flag;
}
    
@endsection

@section('content')
    <div class="container">
        
        <h1 class="text-muted"> Edit Profile </h1>
        
        <form action="/api/student_edit_profile" method="POST" onsubmit="return check();">            
            <div class="border rounded px-2 py-3">
                <div class="form-group">
                    <label for="name" >Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $NAME }}" required>
                    <div class="invalid-feedback">
                        Name can't be empty.
                    </div>
                </div>
                <div class="form-group">
                    <label for="department">Department</label>
                    <input type="text" class="form-control" id="department" name="department" value="{{$data -> department}}" required>
                    <div class="invalid-feedback">
                        Department can't be empty.
                    </div>
                </div>
                <div class="form-group">
                    <label for="grade">Grade</label>
                    <input type="number" min="1" max="8" class="form-control" id="grade" name="grade" value="{{$data -> grade}}" required>
                </div>
                <input type="submit" class="my-2 mx-2 btn btn-primary" value="Submit" >
            </div>
        </form>
        
    </div>
@endsection
