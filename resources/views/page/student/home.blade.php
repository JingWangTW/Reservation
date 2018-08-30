@extends('layouts.student')

@section('custom_head_file')
    <link rel="stylesheet"  href="{{ 'css/timetablejs.css' }}">
    <script src="{{'js/timetable.min.js'}}"></script>
@endsection

@section('title', 'Home Page')

@section('custom_css')
    #timetable
    {
        font-family: consolas;
    }
    .class_interval
    {
        font-weight: bold;
        cursor: pointer;
        font-family: inhereit;
    }
    .class_interval small
    {
        font-weight: bold;
        font-size: 20px;
    }
    #questionInput 
    {
        width: 100%;
        resize: none;
    }
@endsection

@section('custom_js')

let currentClass = {};

function drawSchedule() {
    
    const dateOptions = { weekday: 'short', year: 'numeric', month: 'short', day: '2-digit' };
    
    // convert php array to JS object
    let classList = "{{ json_encode($classList) }}";
    classList = JSON.parse(classList.replace(new RegExp("&quot;", 'g'), "\""));
    
    let timetable = new Timetable();
    
    // use location field to display date
    let dateField = [];
    for ( let index = 0; index < 14; index++ ) {
        
        // get every day date
        let date = new Date(new Date().setTime(Date.now()+1000*60*60*24*index));
        
        // to string
        dateField.push(date.toLocaleDateString('en-US', dateOptions));
    }
    
    // set time between 17 o'clock to 22 o'clock
    timetable.setScope(17, 22);
    
    // add these dates on schedule
    timetable.addLocations(dateField);
    
    // add all class on time table
    for ( let index = 0; index < classList.length; index++ ) {
        
        let classOptions = {
            class: 'class_interval',
            data: classList[index],
            onClick: clickClass,
        }
        
        timetable.addEvent(
            classList[index].class_name, 
            new Date(classList[index].start_time).toLocaleDateString('en-US', dateOptions), 
            new Date(classList[index].start_time), 
            new Date(classList[index].end_time),
            classOptions
        );
    }
    
    // render table on to dom object
    let renderer = new Timetable.Renderer(timetable);
    renderer.draw('#timetable');
}

function clickClass ( classData ) {
    
    currentClass = classData;
    
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
    item.innerHTML = `Start Time: ${classData.start_time}`;
    listNode.appendChild(item);
    
    // append end time of the class
    item = document.createElement('li');
    item.innerHTML = `End Time: ${classData.end_time}`;
    listNode.appendChild(item);
    
    // apend assistant name of the class
    item = document.createElement('li');
    item.innerHTML = `Assistant: ${classData.assistant_name}`;
    listNode.appendChild(item);
    
    // fill in the content
    cardContentNode.appendChild(listNode);
    
    // fill in class index
    $('#classIndex').val(classData.class_index);
    
    // show the class info
    $('#classCard').modal('show');
}

function showReserveForm () {
    
    $('#classCard').modal('hide');
    $('#reserveForm').modal('show');
    
}

// load schedule after render.
addEventListener('load', drawSchedule, false);

@endsection

@section('content')
    <div class="schedule container">
        <h1> Reservation Schedule </h1>
        <p class="lead"> Click the class that you want to reserved. </p>
        
        <!-- Time Table Part -->
        <div class="timetable" id="timetable"></div>
        
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
                    <button type="button" class="btn btn-success" onclick="showReserveForm()"> I want Reserve! </button>
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
                        <div class="form-group row">
                            <label for="classIndex" class="col-sm-3 col-form-label">Class Index</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control form-control-plaintext" id="classIndex" name="classIndex" readonly>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <textarea name="question" rows="5" id="questionInput" class="px-2"
                            placeholder="Please leave the question you want to ask on the class, or just leave it blank and click 'Check!' button to finish reservation."></textarea>
                        </div>
                        
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel </button>
                        <button type="submit" class="btn btn-success"> Check! </button>
                     </div>
                 </form>
              </div>
           </div>
        </div>
    </div>
@endsection
