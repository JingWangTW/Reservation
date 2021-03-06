@extends('layouts.teacher')

@section('title', 'Create Class')

@section('custom_js')
	
function check() {
    
    $('input').removeClass('is-invalid');
    
    let flag = true;

    if ( $('#className').val().trim().length === 0) {
        
        $('#className').addClass('is-invalid');
        
        flag =  false;
        
    }

    return flag;
}
	
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <form class="col-md-10 col-sm-12 col-12" action="/api/create_class" method="POST" onsubmit="return check()">
                <h1 class="text-muted">Create Class</h1>
                <div class="form-group">
                    <label for="className">Class Name</label>
                    <input type="text" class="form-control" id="className" placeholder="Class Name" name="className" required>
                    <div class="invalid-feedback">
                        Class name can't be empty.
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-12 form-group">
                        <label for="academicYear">Academic Year</label>
                        <input type="number" min="107" class="form-control" id="academicYear" value="107" name="academicYear" required>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-12 form-group">
                        <label for="semester">Semester</label>
                        <input type="number" min="1" max="2" class="form-control" id="semester" value="1" name="semester"required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
