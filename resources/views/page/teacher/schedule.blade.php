@extends('layouts.teacher')

@section('title', 'Schedule')

@section('custom_css')
    .schedule
    {
        text-align: center;
    }
@endsection

@section('custom_js')

// convert php array to JS object
let __Class = "{{ json_encode($classList) }}";
const classList = JSON.parse(__Class.replace(new RegExp("&quot;", 'g'), "\""));

let __Assistant = "{{ json_encode($classList) }}";
const assistantList = JSON.parse(__Assistant.replace(new RegExp("&quot;", 'g'), "\""));  

const dateOptions = { weekday: 'short', month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit' };

console.log ( classList);
console.log (assistantList);
    
function fillScheduleTable () {
    
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
        
        // assistant
        col = document.createElement('td');
        col.innerHTML = classList[index].assistant_name;
        newRow.appendChild(col);
        
        // edit and view button
        col = document.createElement('td');
        
        let editButton = document.createElement('button');
        editButton.classList.add("btn", "btn-outline-success", "mx-1");
        editButton.innerHTML = "Edit";
        let viewButton = document.createElement('a');
        viewButton.classList.add("btn", "btn-outline-primary", "mx-1");
        viewButton.setAttribute('href', `/teacher/class_overview/${classList[index].class_index}`);
        viewButton.innerHTML = "View"
        
        col.appendChild(editButton);
        col.appendChild(viewButton);
        newRow.appendChild(col);
        
        tableContentNode.appendChild(newRow);
    }
}

addEventListener('load', fillScheduleTable, false);

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
                    
                    </tbody>
                </table>
            </div>
        </div>
    <div>
@endsection
