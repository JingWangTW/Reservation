@extends('layouts.student')

@section('title', 'Assistant Overview')

@section('content')
    <div class="container">
        <h1> Assistant Overview </h1>
        
        <div class="row mx-0">
            <div class="col-md-3 col-sm-12 col-12">
                <div class="border rounded">
                    
                </div>
            </div>
            <div class="col-md-9 col-sm-12 col-12">
                <div class="border rounded px-2 py-3">
                    <div class="row">
                        <div class="col-3 col-sm-3">
                            Name: 
                        </div>
                        <div class="col-9 col-sm-9">
                            {{$assistant->name}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3 col-sm-3">
                            Skill: 
                        </div>
                        <div class="col-9 col-sm-9">
                            {{$assistant->skill}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection
