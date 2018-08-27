@extends('layouts.app')

@section('home_link')
"/assistant"
@endsection

@section('custom_nav_right')
    @include ('components.assistant_dropdown')
@endsection

