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

function redirectClass ( classIndex ) {
    window.location.href = `/assistant/class_overview/${classIndex}`; 
}

@endsection

@section('content')
    <div class="container">
        <div class="schedule">
            <h1 class="text-muted"> Schedule</h1>
            
            <table class="table table-striped align-middle table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Class Name</th>
                        <th scope="col">Start Time</th>
                        <th scope="col">End Time</th>
                        <th scope="col">Class Room</th>
                        <th scope="col">Amount of Student</th>
                    </tr>
                </thead>
                <tbody id="scheduleContent">
                    @foreach ($classList as $class)
                        <tr onclick="redirectClass('{{$class->class_index}}')">
                            <th scope="col">{{$loop->index+1}}</th>
                            <td>{{$class->class_name}}</th>
                            <td>{{date('D, M d, H:i', strtotime($class->start_time))}}</th>
                            <td>{{date('D, M d, H:i', strtotime($class->end_time))}}</th>
                            <td>{{$class->class_room}}</th>
                            <td>{{$class->people_amount}}</th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    <div>
@endsection
