@extends('layouts.app')

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
@endsection

@section('custom_nav_right')
    @include ('components.teacher_dropdown')
@endsection

@section('content')
    <div class="row justify-content-center">
        <form class="col-lg-8 col-md-10 col-sm-12 col-12" action="/api/create_class" method="POST">
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
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#key" role="tab" aria-controls="key" aria-selected="false">Add By Keyin</a>
                    </li>
                </ul>
                <div class="tab-content px-1 py-2" id="myTabContent">
                    <div class="tab-pane fade show active" id="upload" role="tabpanel" aria-labelledby="home-tab">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupFileAddon">Upload</span>
                            </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile">Choose file</label>
                        </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="key" role="key" aria-labelledby="profile-tab">
                        123
                    </div>
                </div>
            </fieldset>
            
            <input class="btn btn-primary" type="submit" value="Submit">
        </form>
    </div>
@endsection
