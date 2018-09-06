@extends('layouts.assistant')

@section('title', 'Edit Profile')

@section('content')
    <div class="container">
        
        <h1 class="text-muted"> Edit Profile </h1>
        
        <form>
            <div class="row mx-0">
                
                <div class="col-md-3 col-sm-12 col-12">
                    <div class="border rounded">
                        
                        
                    </div>
                </div>
                
                <div class="col-md-9 col-sm-12 col-12">
                    <div class="border rounded px-2 py-3">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="staticEmail" value="email@example.com">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-2 col-form-label">Grade</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="staticEmail" value="email@example.com">
                            </div>
                        </div>
                        <input type="submit" class="my-2 mx-2 btn btn-primary" value="Submit" >
                    </div>
                </div>
                
            </div>
        </form>
        
    </div>
@endsection
