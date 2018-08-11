@extends('layouts.app')

@section('home_link')
"/teacher"
@endsection

@section('custom_nav_right')
    @include ('components.teacher_dropdown')
@endsection

