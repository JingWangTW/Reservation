@extends('layouts.user')

@section('custom_head_file_body')
    
    <link rel="stylesheet"href="https://code.jquery.com/ui/jquery-ui-git.css">
    <link rel="stylesheet" href="{{ 'css/schedule.css' }}">
    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ 'js/schedule.js' }}"></script>
    
@endsection

@section('title', 'Home Page')

@section('custom_css')
    #schedule
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
    let classList = @json($classList);
    
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
        dataWidth: 180,
        click: clickClass,
    })
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

// load schedule after render.
addEventListener('load', drawSchedule, false);

@endsection

@section('content')
    <div class="schedule container">
        <h1> Reservation Schedule </h1>
        <p class="lead"> Please Login to make reservation. </p>
        
        <!-- Time Table Part -->
        <div class="timetable" id="timetable"></div>
        
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
                 </div>
              </div>
           </div>
        </div>
    </div>
@endsection
