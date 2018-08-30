@extends('layouts.teacher')

@section('title', 'New Reservation Class')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <form class="col-lg-8 col-md-10 col-sm-12 col-12" action="/api/add_reservation" method="POST">
                <h1 class="text-muted">New Reservation Class</h1>
                <div class="form-group">
                    <label for="className">Class Name</label>
                    <input type="text" class="form-control" id="className" placeholder="Class Name" name="className" required>
                </div>
                
                <div class="form-group">
                    <label for="classRoom">Class Room</label>
                    <input type="text" class="form-control" id="classRoom" placeholder="Class Room" name="classRoom"required>
                </div>

                <div class="form-group">
                    <label for="startTime">Start Time</label>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="date" class="form-control" id="startDate" name="startTime[]" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <input type="time" class="form-control" id="startTime" name="startTime[]" value="{{ date('H:i') }}" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="startTime">End Time</label>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="date" class="form-control" id="endDate" name="endTime[]" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <input type="time" class="form-control" id="endTime" name="endTime[]" value="{{ date('H:i') }}" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="basic-url">Repeat</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Every </span>
                        </div>
                        <input type="number" class="form-control" id="day" name="repeatDay" value="0" min="0" required>
                        <div class="input-group-prepend">
                            <span class="input-group-text">Day.</span>
                            <span class="input-group-text">For</span>
                        </div>
                        <input type="number" class="form-control" id="time" name="repeatTime" value="0" min="0" required>
                        <div class="input-group-append">
                            <span class="input-group-text">Times.</span>
                        </div>
                    </div>
                    <small class="form-text text-danger">Just leave zero, if the class doesn't need repeat.</small>
                </div>
                
                <div class="form-group">
                    <label for="assistant">Assign Assistant</label>
                    <select class="form-control" id="assistant" name="assistant" required>
                        @foreach ($assistantList as $assistant)
                            <option value="{{ $assistant['account'] }}"> {{ $assistant['name'] }} </option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>            
        </div>
    </div>
@endsection
