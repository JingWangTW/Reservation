@extends('layouts.teacher')

@section('title', 'New Reservation Class')

@section('custom_js')
	
function check() {
    
    $('input').removeClass('is-invalid');
    
    let flag = true;
    
    if ( $('#startTime').val() > $('#endTime').val() || $('#startTime').val() < "17:00" ) {

        $('#startTime').addClass('is-invalid');
        $('#endTime').addClass('is-invalid');
        
        flag =  false;
        
    }
    if ( $('#className').val().trim().length === 0) {
        
        $('#className').addClass('is-invalid');
        
        flag =  false;
        
    }
    if ( $('#classRoom').val().trim().length === 0) {

        $('#classRoom').addClass('is-invalid');
        
        flag =  false;
        
    } 
    
    return flag;
}
	
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <form class="col-md-10 col-sm-12 col-12 needs-validation" action="/api/add_reservation_class" method="POST" onsubmit="return check();" novalidate>
                <h1 class="text-muted">New Reservation Class</h1>
                <div class="form-group">
                    <label for="className">Class Name</label>
                    <input type="text" class="form-control" id="className" placeholder="Class Name" name="className" required>
					<div class="invalid-feedback">
						Class name can't be blank.
					</div>
                </div>
                
                <div class="form-group">
                    <label for="classRoom">Class Room</label>
                    <input type="text" class="form-control" id="classRoom" placeholder="Class Room" name="classRoom" required>
					<div class="invalid-feedback">
						Class room can't be blank.
					</div>
                </div>
				
				<div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="form-group row">
					<div class="col-md-6 col-12">
						<label for="startTime">Start Time</label>
						<input type="time" class="form-control" id="startTime" name="startTime" value="{{ date('H:i') }}" required>
						<div class="invalid-feedback">
							Start time must not later than end time.<br>
							Start time must later than 17:00.<br>
						</div>
					</div>
					<div class="col-md-6 col-12">
						<label for="endTime">End Time</label>
						<input type="time" class="form-control" id="endTime" name="endTime" value="{{ date('H:i') }}" required>
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
