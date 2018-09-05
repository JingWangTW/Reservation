@extends('layouts.teacher')

@section('title', 'Add Students')

@section('custom_css')
    fieldset
    {
        border-width: 2px;
        border-style: groove;
        border-color: threedface;
        border-image: initial;
        min-width: -webkit-min-content;
        -webkit-padding-before: 0.35em;
        -webkit-padding-start: 0.75em;
        -webkit-padding-end: 0.75em;
        -webkit-padding-after: 0.625em;
    }

    legend
    {
        display: block;
        -webkit-padding-start: 2px;
        -webkit-padding-end: 2px;
        border-width: initial;
        border-style: none;
        border-color: initial;
        border-image: initial;
        width: inherit;
    }
    
    #inputGroupFile
    {
        z-index: 10;
    }
@endsection

@section('custom_js')

// to show file name on input blank
function changeFileName( file ) {
    
    let nameLabel = document.getElementById('file_name_label');
    
    if (file && file.files[0]) {
        
        const fileName = file.files[0].name;
    
        nameLabel.innerHTML = fileName;
    
    } else {
        
        nameLabel.innerHTML = "Choose file";

    }
}

// generate input blank to fill in
function handleAmountClick() {
    
    // get the amount of student
    const inputTotal = document.getElementById('student_total').value;
    let studentTotal = inputTotal >= 100 ? 100 : inputTotal;
    
    // clear origin form
    let formDiv = document.getElementById('key_in_student');    
    formDiv.innerHTML = "";
    document.getElementById('btn_submit_total').remove();
    
    // new form
    let newLabel = document.createElement('label');
    newLabel.innerHTML = "Please enter students info:";
    
    formDiv.appendChild(newLabel);
    
    for ( let index = 0; index < studentTotal; index++ ) {
        
        let newDiv = document.createElement('div');
        newDiv.classList.add("row");
        
        // student name
        let nameDiv = document.createElement('div');
        nameDiv.className = 'col-md-6 col-sm-12 col-12 form-group';
        
        let nameLabel = document.createElement('label');
        nameLabel.innerHTML = "Student Name: ";
        
        let nameInput = document.createElement('input');
        nameInput.classList.add('form-control');
        nameInput.setAttribute('name', 'studentName[]');
        nameInput.setAttribute('placeholder', 'Name');
        nameInput.setAttribute('required', true);
        
        nameDiv.appendChild(nameLabel);
        nameDiv.appendChild(nameInput);
        
        newDiv.appendChild(nameDiv);
        
        //-------------------------------------------------//
        // student id
        let idDiv = document.createElement('div');
        idDiv.className = 'col-md-6 col-sm-12 col-12 form-group';
        
        let idLabel = document.createElement('label');
        idLabel.innerHTML = "Student ID: ";
        
        let idInput = document.createElement('input');
        idInput.classList.add('form-control');
        idInput.setAttribute('name', 'studentID[]');
        idInput.setAttribute('placeholder', 'studentID(Account)');
        idInput.setAttribute('required', true);
        
        idDiv.appendChild(idLabel);
        idDiv.appendChild(idInput);
        
        newDiv.appendChild(idDiv);
        
        //-------------------------------------------------//
        // student department
        let deptDiv = document.createElement('div');
        deptDiv.className = 'col-md-6 col-sm-12 col-12 form-group';
        
        let deptLabel = document.createElement('label');
        deptLabel.innerHTML = "Department: ";
        
        let deptInput = document.createElement('input');
        deptInput.classList.add('form-control');
        deptInput.setAttribute('name', 'department[]');
        deptInput.setAttribute('placeholder', 'Department');
        deptInput.setAttribute('required', true);
        
        deptDiv.appendChild(deptLabel);
        deptDiv.appendChild(deptInput);
        
        newDiv.appendChild(deptDiv);
        
        //-------------------------------------------------//
        // student grade
        let gradeDiv = document.createElement('div');
        gradeDiv.className = 'col-md-6 col-sm-12 col-12 form-group';
        
        let gradeLabel = document.createElement('label');
        gradeLabel.innerHTML = "Grade: ";
        
        let gradeInput = document.createElement('input');
        gradeInput.classList.add('form-control');
        gradeInput.setAttribute('name', 'grade[]');
        gradeInput.setAttribute('type', 'number');
        gradeInput.setAttribute('min', '1');
        gradeInput.setAttribute('max', '8');
        gradeInput.setAttribute('placeholder', 'Grade');
        gradeInput.setAttribute('required', true);
        
        gradeDiv.appendChild(gradeLabel);
        gradeDiv.appendChild(gradeInput);
        
        newDiv.appendChild(gradeDiv);
        
        //-------------------------------------------------//
        
        // append to form
        formDiv.appendChild(newDiv);
        
        // make division
        if (index !== studentTotal-1)
        {
            let newHR = document.createElement('hr');
            formDiv.appendChild(newHR);
        }
    }
}
    
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <form class="col-md-10 col-sm-12 col-12" action="/api/add_students" method="POST" enctype="multipart/form-data">
                <h1 class="text-muted">Add Students</h1>
                <fieldset class="mb-3">
                    <legend class="px-2"> Class </legend>
                    
                    <div class="form-group mx-2">
                        <label for="className">Class Name</label>
                        <select class="form-control" id="className" placeholder="Class Name" name="className" required>
                            @foreach ($classList as $class)
                                <option value="{{ $class['classIndex'] }}"> {{ $class['className'] }} </option>
                            @endforeach
                        </select>
                        <small class="form-text text-danger">Please create class first, if necessary.</small>
                    </div>
                </fieldset>
                <fieldset class="mb-3">
                    <legend class="px-2"> Student </legend>
                    
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#upload" role="tab" aria-controls="upload" aria-selected="true">Add By Upload</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#key" role="tab" aria-controls="key" aria-selected="false">Input Manually</a>
                        </li>
                    </ul>
                    
                    <div class="tab-content px-1 py-2" id="myTabContent">
                        
                        <div class="tab-pane fade show active" id="upload" role="tabpanel" aria-labelledby="home-tab">
                            <small class="form-text text-danger">Students must login by their student ID, please key in correctly.</small>
                            <small class="form-text text-danger">Default password would be the same as student ID.</small>
                            <div class="input-group my-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroupFileAddon">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input name="studentFile" type="file" class="custom-file-input" id="inputGroupFile" aria-describedby="inputGroupFileAddon01" onchange="changeFileName(this)" accept=".csv">
                                    <label class="custom-file-label" for="inputGroupFile" id="file_name_label">Choose file</label>
                                </div>
                            </div>
                            <small class="form-text text-danger">Please fill in the table prepare in the sample file.</small>
                            <a class="btn btn-success" href="/file/system/add_student_example.csv"> Download Sample File</a>
                        </div>
                        
                        <div class="tab-pane fade" id="key" role="key" aria-labelledby="profile-tab">
                            <small class="form-text text-danger">Students must login by their student ID, please key in correctly.</small>
                            <small class="form-text text-danger">Default password would be the same as student ID.</small>
                            <div>
                                <div id="key_in_student">
                                    <label for="student_total">How many students to add to this class? </label>
                                    <input type="number" min="1" max="100" class="form-control" id="student_total" value="1" name="student_total" required>
                                </div>
                                <input type="button" class="mt-2 btn btn-success" id="btn_submit_total" onclick="handleAmountClick()" value="Check"> 
                            </div>
                        </div>
                    </div>
                    
                </fieldset>
                
                <input class="btn btn-primary" type="submit" value="Submit">
                
            </form>
        </div>
    </div>
@endsection
