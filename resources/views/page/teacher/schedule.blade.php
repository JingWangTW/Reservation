@extends('layouts.teacher')

@section('title', 'Schedule')

@section('custom_css')
    .schedule
    {
        text-align: center;
    }
@endsection

@section('custom_js')

function editClass ( classIndex ) {
    
    const classList = @json($classList);
    const assistantList = @json($assistantList);
    
    const classData = classList.find( e => e.class_index === classIndex );
    const assistant = assistantList.find( e => e.name === classData.assistant_name );
    
    $('#classIndex').val(classData.class_index);
    $('#className').val(classData.class_name);
    $('#startDate').val(classData.start_time.substr(0, 10));
    $('#startTime').val(classData.start_time.substr(11, 5));
    $('#endDate').val(classData.end_time.substr(0, 10));
    $('#endTime').val(classData.end_time.substr(11, 5));
    $('#classRoom').val(classData.class_room);
    $('#assistant').val(assistant.account);
    
    $('#editForm').modal('show');
}

function deleteClass ( classIndex ) {
    
   //const classList = @json($classList);
    
    //const classData = classList.find( e => e.class_index === classIndex );
    
    $('#deleteClassIndex').val(classIndex);
   // $('#deleteClassName').val(classData.class_name);
    
    $('#deleteForm').modal('show');
}


@endsection

@section('content')
    <div class="row justify-content-center mx-0">
        <div class="col-lg-10 col-md-12 col-sm-12 col-12">
            <div class="schedule">
                <h1> Reservation Class List </h1>
                
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Class Name</th>
                            <th scope="col">Start Time</th>
                            <th scope="col">End Time</th>
                            <th scope="col">Class Room</th>
                            <th scope="col">Assistant</th>
                            <th scope="col">Other</th>
                        </tr>
                    </thead>
                    <tbody id="scheduleContent">
                        @foreach ($classList as $class)
                            <tr>
                                <th scope="col">{{$loop->index+1}}</th>
                                <td>{{$class->class_name}}</th>
                                <td>{{$class->start_time}}</th>
                                <td>{{$class->end_time}}</th>
                                <td>{{$class->class_room}}</th>
                                <td>{{$class->assistant_name}}</th>
                                <td>
                                    <button class="btn btn-outline-success mx-1" onclick="editClass('{{$class->class_index}}')"> Edit </button>
                                    <a class="btn btn-outline-primary mx-1" href="/teacher/class_overview/{{$class->class_index}}"> View </a>
                                    <button class="btn btn-danger mx-1" onclick="deleteClass('{{$class->class_index}}')"> Delete </button>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    <div>
    <div class="modal" id="editForm" tabindex="-1" role="dialog" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title"> Edit Class Info </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
             </div>
             <form action="/api/edit_reservation_class" method="POST">
                 <div class="modal-body" id="question">
                    
                    <div class="form-group row">
                        <label for="classIndex" class="col-sm-3 col-form-label">Class Index</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-plaintext" id="classIndex" name="classIndex" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="className" class="col-sm-3 col-form-label">Class Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="className" name="className" autofocus required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="startTime" class="col-sm-3 col-form-label">Start Time</label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-md-6 pr-0">
                                    <input type="date" class="form-control" id="startDate" name="startTime[]" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="time" class="form-control" id="startTime" name="startTime[]" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="endTime" class="col-sm-3 col-form-label">End Time</label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-md-6 pr-0">
                                    <input type="date" class="form-control" id="endDate" name="endTime[]" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="time" class="form-control" id="endTime" name="endTime[]" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="classRoom" class="col-sm-3 col-form-label">Class Room</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="classRoom" name="classRoom" required>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="assistant" class="col-sm-3 col-form-label">Assistant</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="assistant" name="assistant" required>
                                @foreach ($assistantList as $assistant)
                                    <option value="{{ $assistant['account'] }}"> {{ $assistant['name'] }} </option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>
                    
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel </button>
                    <button type="submit" class="btn btn-success"> Edit </button>
                 </div>
             </form>
          </div>
       </div>
    </div>
    <div class="modal" id="deleteForm" tabindex="-1" role="dialog" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title"> Delet Class </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
             </div>
             <form action="/api/delete_reservation_class" method="POST">
                 <div class="modal-body" id="delete">
                    
                    <input style="display: none;"id="deleteClassIndex" name="classIndex" readonly>
                    
                    Sure To Delete This Class ?
                    
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel </button>
                    <button type="submit" class="btn btn-danger"> Delete </button>
                 </div>
             </form>
          </div>
       </div>
    </div>
@endsection
