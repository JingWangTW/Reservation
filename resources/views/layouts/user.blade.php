@extends('layouts.app')

@section('home_link')
"/home"
@endsection

@section('custom_nav_right')
     @include ('components.login_form')
@endsection

