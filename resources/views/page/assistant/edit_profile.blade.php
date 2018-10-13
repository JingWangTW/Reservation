@extends('layouts.assistant')

@section('title', 'Edit Profile')

@section('custom_css')

    .img-block {
        padding-top: 100px;
        text-align: center;
        padding-bottom: 100px;
    }

    img {
        max-width: 100%;
        object-fit: contain;
    }

    #fileNameLabel {
        z-index: 0;
        overflow: hidden;
    }

@endsection

@section('custom_js')

function uploadImg( e ) {

    if ( e.target.files &&e.target.files[0] ) {
        
        let reader = new FileReader();
        const fileName = e.target.files[0].name;

        reader.onload = ( e ) => {
            
            let img = document.getElementById("imgPreview");
            let div = document.getElementById('fileHint');
            let label = document.getElementById('fileNameLabel');

            img.setAttribute('src', e.target.result);
            label.innerHTML = fileName;

            img.classList.remove('d-none');
            div.classList.add('d-none');
        }

        reader.readAsDataURL(e.target.files[0]);
    }
}

function initImg () {

    @isset($assistant -> img )
       
        @if ( $assistant -> img != "")

            let img = document.getElementById('imgPreview');
            let div = document.getElementById('fileHint');

            img.setAttribute('src', "/get-file/img/" + "{{ $assistant -> img}}" );

            img.classList.remove('d-none');
            div.classList.add('d-none');
        
        @endif

    @endisset
}

document.getElementById('img').addEventListener ( 'change', uploadImg );
initImg();
@endsection

@section('content')
    <div class="container">
        
        <h1 class="text-muted"> Edit Profile </h1>
        
        <form action="/api/assistant_edit_profile" method="POST" enctype="multipart/form-data" id="profile_form">
            <div class="row mx-0">
                <div class="col-md-3 col-sm-12 col-12">
                    <div class="border rounded">
                        <div class="img-block bg-light" id="fileHint"> 
                            Upload Your Profile Image.
                        </div>
                        <img id="imgPreview" class="d-none" src="#" height="300px">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="img" accept="image/*" name="img">
                                <label class="custom-file-label" for="img" id="fileNameLabel"> Choose File... </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-9 col-sm-12 col-12">
                    <div class="border rounded px-2 py-3">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" value="{{ $assistant -> name}}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="department" class="col-sm-2 col-form-label"> Department </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="department" name="department" value="{{ $assistant -> department  }}" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="department" class="col-sm-2 col-form-label"> Grade </label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="grade" name="grade" min="1" max="8" value="{{ $assistant -> grade  }}" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="talent" class="col-sm-2 col-form-label"> Specialty </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="talent" name="talent" value="{{ $assistant -> talent  }}" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="subject" class="col-lg-3 col-sm-4 col-form-label"> Language Ability </label>
                            <div class="col-lg-9 col-sm-8">
                                <input type="text" class="form-control" id="ability" name="ability" value="{{ $assistant -> ability  }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="subject" class="col-xl-3 col-lg-4 col-sm-5 col-form-label"> Counseling Subject </label>
                            <div class="col-xl-9  col-lg-8 col-sm-7">
                                <input type="text" class="form-control" id="subject" name="subject" value="{{ $assistant -> subject  }}">
                            </div>
                        </div>

                        <input type="submit" class="my-2 mx-2 btn btn-primary" value="Submit" >
                    </div>
                </div>
                
            </div>
        </form> 
    </div>
@endsection
