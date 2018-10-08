@extends('layouts.teacher')

@section('title', 'Edit Profile')

@section('custom_css')

    img {
        max-width: 100%;
        object-fit: contain;
    }

    #fileNameLabel {
        z-index: 0;
    }

@endsection

@section('content')
    <div class="container">
        
        <h1 class="text-muted"> Profile </h1>
        
            <div class="row mx-0">
                <div class="col-md-3 col-sm-12 col-12">
                    <div class="border rounded">
                        <img src="/get-file/img/{{$assistant -> img}}" height="300px">
                    </div>
                </div>
                
                <div class="col-md-9 col-sm-12 col-12">
                    <div class="border rounded px-2 py-3">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" value="{{ $assistant -> name}}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="row">
                                    <label for="department" class="col-sm-4 col-form-label"> Department </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="department" name="department" value="{{ $assistant -> department  }}"  disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <label for="department" class="col-sm-2 col-form-label"> Grade </label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="grade" name="grade" min="1" max="8" value="{{ $assistant -> grade  }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subject" class="col-sm-2 col-form-label"> Subject </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="subject" name="subject" value="{{ $assistant -> subject  }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="talent" class="col-sm-2 col-form-label"> Talent </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="talent" name="talent" value="{{ $assistant -> talent  }}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="subject" class="col-sm-2 col-form-label"> English Ability </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="ability" name="ability" value="{{ $assistant -> ability  }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
    </div>
@endsection
