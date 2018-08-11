@extends('layouts.app')

@section('content')
    <div class="warn-div">
        <div class="alert-danger">
            <?php
                echo $message;
            ?>
        </div>
    </div>
@endsection
