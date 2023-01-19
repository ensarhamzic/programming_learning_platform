@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/teacher.css') }}" />
@endsection

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add Course Content</div>
        <div class="card-body">
          <form method="POST" action="{{ route('teacher.courses.addContent', $course->id) }}" novalidate id="form"
            enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
              <label for="section" class="col-md-4 col-form-label text-md-end">Section</label>

              <div class="col-md-6">
                <select name="section" id="section" class="form-control @error('section') is-invalid @enderror">
                  @foreach ($course->sections as $section)
                  <option value="{{ $section->id }}">{{ $section->title }}</option>
                  @endforeach
                </select>

                @error('section')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>


            <div class="row mb-3">
              <label for="title" class="col-md-4 col-form-label text-md-end">Content Title</label>

              <div class="col-md-6">
                <input id="title" type="title" class="form-control @error('title') is-invalid @enderror" name="title"
                  value="{{ old('title') }}" required autocomplete="title" autofocus>

                @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

                <span class="invalid-feedback" role="alert" id="titleError"></span>
              </div>
            </div>

            <div class="row mb-3">
              <label for="content" class="col-md-4 col-form-label text-md-end">Content</label>

              <div class="col-md-6">
                <input id="content" type="file" class="form-control @error('content') is-invalid @enderror"
                  name="content" required rows="10" autocomplete="current-content" />

                @error('imageURI')
                <span class="invalid-feedback" role="alert" id="imageServerError">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

                <span class="invalid-feedback" role="alert" id="contentError"></span>
              </div>
            </div>

            <input type="hidden" name="contentType" value="" id="contentType" />

            <div class="d-flex justify-content-center align-items-center">
              <button type="submit" class="btn btn-primary">
                Add Content
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  document.getElementById("form").onsubmit = function (e) {
        e.preventDefault();
        let formValid = true;

        let title = document.getElementById('title');
        let titleError = document.getElementById('titleError');

        let content = document.getElementById('content');
        let contentError = document.getElementById('contentError');
        
        if(title.value.trim().length < 1) {
            titleError.innerHTML = "Title must not be empty";
            titleError.style.display = "block";
            formValid = false;
        } else {
            titleError.style.display = "none";
        }


        let fileValid = true;
        if(content.files.length < 1) {
            contentError.innerHTML = "Content must not be empty";
            contentError.style.display = "block";
            formValid = false;
        } else {
          const file = content.files[0];
          const fileType = file.type;
          if(fileType.startsWith('image/')) {
            document.getElementById('contentType').value = 'image';
          } else if(fileType.startsWith('video/')) {
            document.getElementById('contentType').value = 'video';
          } else if(fileType === 'application/pdf') {
            document.getElementById('contentType').value = 'pdf';
          } else if(fileType === 'application/vnd.ms-powerpoint'
          || fileType === 'application/vnd.openxmlformats-officedocument.presentationml.presentation') {
            document.getElementById('contentType').value = 'powerpoint';
          } else if(fileType === 'application/msword') {
            document.getElementById('contentType').value = 'document';
          } else if(fileType === 'application/x-rar-compressed' || fileType === 'application/octet-stream' || fileType === 'application/x-zip-compressed') {
            document.getElementById('contentType').value = 'zip';
          } else {
            formValid = false;
            fileValid = false;
          }

          if (!fileValid) {
            contentError.innerHTML = "Content must be a video, pdf, powerpoint presentation, ms word document or zip file";
            contentError.style.display = "block";
            formValid = false;
          } else {
            contentError.style.display = "none";
          }
        }

        if(formValid) {
            this.submit();
        }
         
    }
</script>
@endsection