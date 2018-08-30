@extends('layouts.assistant')

@section('title', 'Class Overview')

@section('custom_js')

function init() {
    
    const dateOptions = { month: 'short', day: 'numeric', minute: '2-digit', second: '2-digit' };

    // convert php array to JS object
    let classData = "{{ json_encode($classInfo) }}";
    classData = JSON.parse(classData.replace(new RegExp("&quot;", 'g'), "\""));
    
    // student table part
    let studentTable = document.getElementById('studentInfo');
    
    // student info part
    classData.student.forEach(( student, index ) => {
        
        let newRow = document.createElement('tr');
        
        // index col
        let headCol = document.createElement('th');
        headCol.setAttribute('scope', 'col');
        headCol.innerHTML = index + 1;
        newRow.appendChild(headCol);
        
        // student name
        let col = document.createElement('td');
        col.innerHTML = student.name;
        newRow.appendChild(col);
        
        // student ID
        col = document.createElement('td');
        col.innerHTML = student.student_id;
        newRow.appendChild(col);
        
        // student department
        col = document.createElement('td');
        col.innerHTML = student.department;
        newRow.appendChild(col);
        
        // student grade
        col = document.createElement('td');
        col.innerHTML = student.grade;
        newRow.appendChild(col);
        
        // student question
        col = document.createElement('td');
        col.innerHTML = student.question;
        newRow.appendChild(col);
        
        studentTable.appendChild(newRow);
    });
    
    // class info part
    let classInfo = document.getElementById('infoBox');
    
    // class name
    let list = document.createElement('li');
    list.innerHTML = `Class Name: ${classData.class_name}`;
    classInfo.appendChild(list);
    
    // start time
    list = document.createElement('li');
    list.innerHTML = `Start Time: ${new Date(classData.start_time).toLocaleDateString('en-US', dateOptions)}`;
    classInfo.appendChild(list);
    
    // end time
    list = document.createElement('li');
    list.innerHTML = `End Time: ${new Date(classData.start_time).toLocaleDateString('en-US', dateOptions)}`;
    classInfo.appendChild(list);
    
    // class room
    list = document.createElement('li');
    list.innerHTML = `Class Room: ${classData.class_room}`;
    classInfo.appendChild(list);
    

}

addEventListener('load', init, false);

@endsection

@section('content')
    <div class="row justify-content-center">
        <div  class="col-lg-10 col-md-11 col-sm-12 col-12">
            <div class="class-info">
                <h1> Class Info </h1>
                <div class="row mt-2">
                    <div class="col-md-9">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Student ID</th>
                                    <th scope="col">Department</th>
                                    <th scope="col">Grade</th>
                                    <th scope="col">Question</th>
                                </tr>
                            </thead>
                            <tbody id="studentInfo">
                            
                            </tbody>
                        </table>
                        
                    </div>
                    
                    <div class="col-md-3">
                        <div class="py-2 px-1 border rounded">
                        <ul class="" id="infoBox">
                            
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
