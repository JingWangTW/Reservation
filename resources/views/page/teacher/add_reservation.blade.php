@extends('layouts.teacher')

@section('title', 'Add Reservation Class')

@section('content')
    <div class="row justify-content-center">
        <form class="col-lg-8 col-md-10 col-sm-12 col-12" action="/api/add_reservation" method="POST">
            <div class="row">
                <div class="col-lg-6 col-sm-12 col-12 form-group">
                    <label for="className">Class Name</label>
                    <input type="text" class="form-control" id="className" placeholder="Class Name" name="className" required>
                </div>
                <div class="col-lg-6 col-sm-12 col-12 form-group">
                    <label for="classRoom">Class Room</label>
                    <input type="text" class="form-control" id="classRoom" placeholder="Class Room" name="classRoom"required>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-sm-12 col-12 form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>
                <div class="col-lg-6 col-sm-12 col-12 form-group">
                    <label for="time">Time</label>
                    <input type="time" class="form-control" id="time" name="time" required>
                </div>
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
@endsection
