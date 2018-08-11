@extends('layouts.app')

@section('content')
    <div class="warn-div">
        <div class="alert-danger">        
            {{ $message }}
        </div>
    </div>
@endsection
