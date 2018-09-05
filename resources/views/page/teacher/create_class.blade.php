@extends('layouts.teacher')

@section('title', 'Create Class')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <form class="col-md-10 col-sm-12 col-12" action="/api/create_class" method="POST">
                <h1 class="text-muted">Create Class</h1>
                <div class="form-group">
                    <label for="className">Class Name</label>
                    <input type="text" class="form-control" id="className" placeholder="Class Name" name="className" required>
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
