@extends('layouts.assistant')

@section('title', 'Home Page')

@section('custom_css')
    .schedule
    {
        text-align: center;
    }
    #scheduleContent tr 
    {
        cursor: pointer;
    }
@endsection

@section('custom_js')
    
function fillScheduleTable () {
    
    const dateOptions = { weekday: 'short', year: 'numeric', month: 'short', day: '2-digit', minute: '2-digit', second: '2-digit' };

    // convert php array to JS object
    let classList = "{{ json_encode($classList) }}";
    classList = JSON.parse(classList.replace(new RegExp("&quot;", 'g'), "\""));
    
    let tableContentNode = document.getElementById("scheduleContent");
    
    // go through each row
    for (let index = 0; index < classList.length; index++ ) {
        
        let newRow = document.createElement('tr');
        
        // index
        let headCol = document.createElement('th');
        headCol.setAttribute('scope', 'row');
        headCol.innerHTML = index + 1;
        newRow.appendChild(headCol);
        
        // class name
        let col = document.createElement('td');
        col.innerHTML = classList[index].class_name;
        newRow.appendChild(col);
        
        // class start time
        col = document.createElement('td');
        col.innerHTML = new Date(classList[index].start_time).toLocaleDateString('en-US', dateOptions);
        newRow.appendChild(col);
        
        // class end time
        col = document.createElement('td');
        col.innerHTML = new Date(classList[index].end_time).toLocaleDateString('en-US', dateOptions);
        newRow.appendChild(col);
        
        // class room
        col = document.createElement('td');
        col.innerHTML = classList[index].class_room;
        newRow.appendChild(col);
        
        // redirect to view page
        newRow.addEventListener( 'click', () => {
            window.location.href = `/assistant/class_overview/${classList[index].class_index}`; 
        }, false );
        
        tableContentNode.appendChild(newRow);
    }
}

addEventListener('load', fillScheduleTable, false);

@endsection

@section('content')
    <div class="container">
        <div class="schedule">
            <h1> Schedule</h1>
            
            <table class="table table-striped align-middle table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Class Name</th>
                        <th scope="col">Start Time</th>
                        <th scope="col">End Time</th>
                        <th scope="col">Class Room</th>
                    </tr>
                </thead>
                <tbody id="scheduleContent">
                
                </tbody>
            </table>
        </div>
    <div>
@endsection
