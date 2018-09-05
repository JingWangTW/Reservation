@extends('layouts.student')

@section('custom_head_file_body')
    
    <link rel="stylesheet"href="https://code.jquery.com/ui/jquery-ui-git.css">
    <link rel="stylesheet" href="{{ 'css/schedule.css' }}">
    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ 'js/schedule.js' }}"></script>
    
@endsection

@section('title', 'Home Page')

@section('custom_css')
    #schedule, .legend
    {
        font-family: consolas;
    }
    #questionInput, #editQuestionInput
    {
        width: 100%;
        resize: none;
    }
    .reserved {
        background-color: green !important;
    }
    
    span.icon {
        height: 0px;
        width: 0px;
        padding-right: 20px;
        margin-right: 5px;
        margin-left: 5px;
    }
    span.icon.availbale {
        background-color: #4f93d6;
    }
    span.icon.reserved {
        background-color: green;
    }
    span.icon.non-free {
        background-color: red;
    }
@endsection

@section('custom_js')

let currentClass = {};
const dateOptions = { weekday: 'short', year: 'numeric', month: 'short', day: '2-digit' };

function drawSchedule() {
    
    // convert php array to JS object
    let classList = @json($classList);
    let recordList = @json($recordList);
    
    // get all rows data;
    let classCounter = 0;
    let rows = {};
    for ( let index = 0; index < 14; index++ ) {
        
        // get every day date
        let date = new Date(new Date().setTime(Date.now()+1000*60*60*24*index)).toLocaleDateString('en-US', dateOptions);
        let newRow = {};
        
        newRow.title = date
        newRow.schedule = [];
        
        // check if current class is on the date of above
        while ( classCounter < classList.length && 
            new Date(classList[classCounter].start_time).toLocaleDateString('en-US', dateOptions) === date ) {
            
            let newEvent = {};
            newEvent.start = new Date(classList[classCounter].start_time).toLocaleTimeString('en-us', {'hour': '2-digit', 'minute': '2-digit', 'hour12': false});
            newEvent.end = new Date(classList[classCounter].end_time).toLocaleTimeString('en-us', {'hour': '2-digit', 'minute': '2-digit', 'hour12': false});
            newEvent.text = classList[classCounter].class_name;
            newEvent.data = classList[classCounter];
            
            // check if reserved 
            const findRecord = recordList.find((e) =>  e.class_index === classList[classCounter].class_index )
            if ( findRecord ) {
                newEvent.class = "reserved";
                newEvent.data.question = findRecord.question;
                newEvent.data.reserved = true;
            }
            
            newRow.schedule.push(newEvent);
            
            classCounter++;
        }
        
        rows[index] = newRow;
    }
    
    $("#schedule").timeSchedule({
        rows: rows,
        startTime: '17:00',
        endTime: '22:00',
        widthTimeX: 30,
        dataWidth: 190,
        click: clickClass,
    });
}

function clickClass ( node, classData ) {
    
    classData = classData.data;
    
    currentClass = classData.data;
    
    // get the dom node to fill in
    let cardTitleNode = document.getElementById('className');
    let cardContentNode = document.getElementById('classInfo');
    
    // clear the dom node
    cardTitleNode.innerHTML = "";
    cardContentNode.innerHTML = "";
    
    // fill in the class name
    cardTitleNode.innerHTML =  classData.class_name;
    
    // list to show class data
    let listNode = document.createElement('ul');
    
    // append class name
    let item = document.createElement('li');
    item.innerHTML = `Class: ${classData.class_name}`;
    listNode.appendChild(item);
    
    // append class room
    item = document.createElement('li');
    item.innerHTML = `Class Room: ${classData.class_room}`;
    listNode.appendChild(item);
    
    // append start time of the class
    item = document.createElement('li');
    item.innerHTML = `Start Time: ${new Date(classData.start_time)
                                    .toLocaleDateString('en-us', {
                                        ...dateOptions, 
                                        'hour': '2-digit', 
                                        'minute': 'numeric',
                                        'weekday': undefined,
                                    })}`;
    listNode.appendChild(item);
    
    // append end time of the class
    item = document.createElement('li');
    item.innerHTML = `End Time: ${new Date(classData.end_time)
                                    .toLocaleDateString('en-us', {
                                        ...dateOptions, 
                                        'hour': '2-digit', 
                                        'minute': 'numeric',
                                        'weekday': undefined,
                                    })}`;
    listNode.appendChild(item);
    
    // apend assistant name of the class
    item = document.createElement('li');
    item.innerHTML = `Assistant: ${classData.assistant_name}`;
    listNode.appendChild(item);
    
    // fill in the content
    cardContentNode.appendChild(listNode);
    
    // fill in class index
    $('#classIndex').val(classData.class_index);
    
    // fill in class name
    $('#submitClassName').val(classData.class_name);
    
    // prepsare reservation form, edit or new.
    if ( classData.reserved ) {

        $('#makeReserveButton').hide();
        $('#editReserveButton').show();
        
        $('#editClassIndex').val(classData.class_index);
        $('#deleteClassIndex').val(classData.class_index);
        $('#editClassName').val(classData.class_name);
        $('#editQuestionInput').val(classData.question);
        
    } else {
        
        $('#makeReserveButton').show();
        $('#editReserveButton').hide();
    }
    
    // check if in the editable range
    const duration = new Date(classData.start_time) - Date.now();
    if ( duration < 1000*60*2 ) {
        $("#makeReserveButton").prop('disabled', true);  
        $("#addRecordSubmitButton").prop('disabled', true);  
        $("#editButton").prop('disabled', true);  
        $("#deleteButton").prop('disabled', true);  
        $("#questionInput").prop('disabled', true);  
        $("#editQuestionInput").prop('disabled', true);  
    } else {
        $("#makeReserveButton").prop('disabled', false);  
        $("#addRecordSubmitButton").prop('disabled', false);  
        $("#editButton").prop('disabled', false);  
        $("#deleteButton").prop('disabled', false);  
        $("#questionInput").prop('disabled', false);  
        $("#editQuestionInput").prop('disabled', false);  
    }
    
    // show the class info
    $('#classCard').modal('show');
}

function showBlankReserveForm () {
    
    $('#classCard').modal('hide');
    $('#reserveForm').modal('show');
    $('#editReserveForm').modal('hide');
}

function showEmptyReserveForm () {
    
    $('#classCard').modal('hide');
    $('#reserveForm').modal('hide');
    $('#editReserveForm').modal('show');
    
}

// load schedule after render.
addEventListener('load', drawSchedule, false);

@endsection

@section('content')
    <div class="schedule container">
        <h1> Reservation Schedule </h1>
        <p class="lead"> Click the class that you want to reserved. </p>
        <div class="text-right legend">
            <div class="d-inline-block mt-1 mt-sm-0">
                <span class="icon availbale"></span> Available Class
            </div>
            <div class="d-inline-block mt-1 mt-sm-0">
                <span class="icon reserved"></span> Reserved Class
            </div>
            <div class="d-inline-block mt-1 mt-sm-0">
                <span class="icon non-free"></span> Non-free Class
            </div>
        </div>
        <!-- Time Table Part -->
        <div id="schedule"></div>
        
        <!-- Reservation Class Info -->
        <div class="modal fade" id="classCard" tabindex="-1" role="dialog" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                 <div class="modal-header">
                    <h5 class="modal-title" id="className">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                 </div>
                 <div class="modal-body" id="classInfo">
                    
                 </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Close </button>
                    <button type="button" id="makeReserveButton" class="btn btn-success" onclick="showBlankReserveForm()"> I want Reserve! </button>
                    <button type="button" id="editReserveButton" class="btn btn-success" onclick="showEmptyReserveForm()"> Edit Record! </button>
                 </div>
              </div>
           </div>
        </div>
        
        <div class="modal" id="reserveForm" tabindex="-1" role="dialog" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                 <div class="modal-header">
                    <h5 class="modal-title"> Please leave the question you met. </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                 </div>
                 <form action="/api/making_reservation" method="POST">
                     <div class="modal-body" id="question">
                        <input style="display: none" type="text" name="classIndex" id="classIndex" readonly>
                        <div class="form-group row">
                            <label for="className" class="col-sm-3 col-form-label">Class Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-plaintext" id="submitClassName" name="className" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <textarea name="question" rows="5" id="questionInput" class="px-2"
                            placeholder="Please leave the question you want to ask on the class, or just leave it blank and click 'Check!' button to finish reservation."></textarea>
                        </div>
                        
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel </button>
                        <button type="submit" class="btn btn-success" id="addRecordSubmitButton"> Check! </button>
                     </div>
                 </form>
              </div>
           </div>
        </div>
        <div class="modal" id="editReserveForm" tabindex="-1" role="dialog" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                 <div class="modal-header">
                    <h5 class="modal-title"> Edit the reserve record. </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                 </div>
                 <form style="display: none" action="/api/delete_reservation_record" method="POST" id="deleteRecordForm">
                    <input style="display: none" type="text" name="classIndex" id="deleteClassIndex" readonly>
                 </form>
                 
                 <form action="/api/edit_reservation_record" method="POST" id="editRecordForm">
                     <div class="modal-body" id="question">
                        <input style="display: none" type="text" name="classIndex" id="editClassIndex" readonly>
                        <div class="form-group row">
                            <label for="className" class="col-sm-3 col-form-label">Class Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-plaintext" id="editClassName" name="className" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <textarea name="question" rows="5" id="editQuestionInput" class="px-2"
                            placeholder="Please leave the question you want to ask on the class, or just leave it blank and click 'Check!' button to finish reservation."></textarea>
                        </div>
                        
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel </button>
                        <button type="submit" class="btn btn-danger" form="deleteRecordForm" id="deleteButton"> Delete! </button>
                        <button type="submit" class="btn btn-success" form="editRecordForm" id="editButton"> Submit! </button>
                     </div>
                 </form>
              </div>
           </div>
        </div>
    </div>
@endsection
