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

    function changeFileName( file ) {
        
        let nameLabel = document.getElementById('file_name_label');
        
        if (file && file.files[0]) {
            
            const fileName = file.files[0].name;
        
            nameLabel.innerHTML = fileName;
        
        } else {
            
            nameLabel.innerHTML = "Choose file";

        }
    }
    
    function handleAmountClick() {
        
        let studentTotal = document.getElementById('student_total').value;
        let formDiv = document.getElementById('key_in_student');
        
        formDiv.innerHTML = "";
        document.getElementById('btn_submit_total').remove();
                
        let newLabel = document.createElement('label');
        newLabel.innerHTML = "Please enter students info:";
        
        formDiv.appendChild(newLabel);
        
        for ( let index = 0; index < studentTotal; index++ ) {
            
            let newDiv = document.createElement('div');
            newDiv.classList.add("row");
            
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
            
            formDiv.appendChild(newDiv);
            
            if (index !== studentTotal-1)
            {
                let newHR = document.createElement('hr');
                formDiv.appendChild(newHR);
            }
        }
    }
    
@endsection

@section('content')
    <div class="row justify-content-center">
        <form class="col-md-10 col-sm-12 col-12" action="/api/add_students" method="POST">
        
            <fieldset class="mb-3">
                <legend class="px-2"> Class </legend>
                
                <div class="form-group mx-2">
                    <label for="className">Class Name</label>
                    <select class="form-control" id="className" placeholder="Class Name" name="className" required>
                        @foreach ($classList as $class)
                            <option vlaue="{{ $class['classIndex'] }}"> {{ $class['className'] }} </option>
                        @endforeach
                    </select>
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
                        <div class="input-group my-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon">Upload</span>
                            </div>
                            <div class="custom-file">
                                <input name="studentFile" type="file" class="custom-file-input" id="inputGroupFile" aria-describedby="inputGroupFileAddon01" onchange="changeFileName(this)" accept=".csv">
                                <label class="custom-file-label" for="inputGroupFile" id="file_name_label">Choose file</label>
                            </div>
                        </div>
                        <a class="btn btn-success" href="/file/system/add_student_example.csv"> Download Sample File</a>
                    </div>
                    
                    <div class="tab-pane fade" id="key" role="key" aria-labelledby="profile-tab">
                        <div>
                            <div id="key_in_student">
                                <label for="student_total">How many students to add to this class? </label>
                                <input type="number" min="1" class="form-control" id="student_total" value="1" name="student_total" required>
                            </div>
                            <input type="button" class="mt-2 btn btn-success" id="btn_submit_total" onclick="handleAmountClick()" value="Check"> 
                        </div>
                    </div>
                </div>
                
            </fieldset>
            
            <input class="btn btn-primary" type="submit" value="Submit">
            
        </form>
    </div>
@endsection
