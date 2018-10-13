@extends('layouts.teacher')

@section('title', 'Class Overview')

@section('content')
    <div class="row justify-content-center mx-0">
        <div  class="col-lg-10 col-md-12 col-sm-12 col-12 mx-2">
            <div class="class-info">
                <h1 class="ml-1"> Class Info </h1>
                <div class="row mt-2">
                    <div class="col-lg-9 col-md-12 order-lg-1 order-2 mt-2 mt-lg-0">
                        <table class="table table-striped table-bordered table-hover table-response">
                            <colgroup>
                                <col style="width:5%">
                                <col style="width:15%">
                                <col style="width:13%">
                                <col style="width:20%">
                                <col style="width:8%">
                                <col style="width:34%">
                            </colgroup>
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
                                @foreach ($classInfo['student'] as $student)
                                    <tr>
                                        <th scope="col">{{$loop->index+1}}</th>
                                        <td>{{$student->name}}</th>
                                        <td>{{$student->student_id}}</th>
                                        <td>{{$student->department}}</th>
                                        <td>{{$student->grade}}</th>
                                        <td>{{$student->question}}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="col-lg-3 col-md-12 order-lg-2 order-1">
                        <div class="py-2 px-1 border rounded">
                            <ul class="" id="infoBox">
                                <li>Class Name: {{$classInfo['class_name']}}</li>
                                <li>Start Time: {{date('m/d, H:i', strtotime($classInfo['start_time']))}}</li>
                                <li>End Time: {{date('m/d, H:i', strtotime($classInfo['end_time']))}}</li>
                                <li>Class Room: {{$classInfo['class_room']}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
