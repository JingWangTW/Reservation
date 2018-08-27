@extends('layouts.app')

@section('home_link')
"/student"
@endsection

@section('custom_nav_right')
    @include ('components.student_dropdown')
@endsection

