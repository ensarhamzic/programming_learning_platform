@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/teacher.css') }}" />
@endsection

@section('content')

<div style="display:none;" id="cropModal">
  <div class="overlay"></div>
  <div class="card cropModal">
    <div class="card-header">Crop banner image</div>
    <div class="card-body cropDiv">
      <img id="image" class="image">
    </div>
    <div class="card-footer d-flex justify-content-center align-items-center">
      <button class="btn btn-success cropBtn customBtn" id="cropBtn">Crop image</button>
    </div>
  </div>
</div>



<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Create New Course</div>
        <div class="card-body">
          <form method="POST" action="{{ route('teacher.courses.store') }}" novalidate id="form">
            @csrf

            <div class="row mb-3">
              <label for="title" class="col-md-4 col-form-label text-md-end">Course Title</label>

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
              <label for="description" class="col-md-4 col-form-label text-md-end">Course Description</label>

              <div class="col-md-6">
                <textarea id="description" type="description"
                  class="form-control @error('description') is-invalid @enderror" name="description" required rows="10"
                  autocomplete="current-description">{{ old('description') }}</textarea>

                @error('description')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

                <span class="invalid-feedback" role="alert" id="descriptionError"></span>
              </div>
            </div>

            <div class="row mb-3">
              <label for="description" class="col-md-4 col-form-label text-md-end">Course Banner</label>

              <div class="col-md-6">
                <input id="courseImage" type="file" onchange="pictureChange()"
                  class="form-control @error('courseImage') is-invalid @enderror" name="courseImage" required rows="10"
                  autocomplete="current-courseImage" accept="image/png, image/jpeg, image/jpg" />

                @error('imageURI')
                <span class="invalid-feedback" role="alert" id="imageServerError">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

                <span class="invalid-feedback" role="alert" id="courseImageError"></span>
              </div>
            </div>
            <input type="hidden" name="imageURI" value="" id="imageURI" />

            <div class="createActions">
              <button type="submit" class="btn btn-primary customBtn">
                Create Course
              </button>
              <button type="button" class="btn btn-secondary" onclick="javascript:history.back()">Cancel</button>
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

        let description = document.getElementById('description');
        let descriptionError = document.getElementById('descriptionError');

        let courseImage = document.getElementById('courseImage');
        let courseImageError = document.getElementById('courseImageError');

        
        if(title.value.length < 5) {
            titleError.innerHTML = "Title must be at least 5 characters long";
            titleError.style.display = "block";
            formValid = false;
        } else {
            titleError.style.display = "none";
        }

        if(description.value.length < 30) {
            descriptionError.innerHTML = "Description must be at least 30 characters long";
            descriptionError.style.display = "block";
            formValid = false;
        } else {
            descriptionError.style.display = "none";
        }

        if(courseImage.files.length == 0) {
            courseImageError.innerHTML = "Please select a course image";
            courseImageError.style.display = "block";
            formValid = false;
        } else {
          if(courseImage.files[0].type.match(/^image\//)) {
            courseImageError.style.display = "none";
          } else {
            courseImageError.innerHTML = "Please select a valid image";
            courseImageError.style.display = "block";
            formValid = false;
          }
        }




        if(formValid) {
            this.submit();
        }
         
    }




    const pictureChange = function () {
        let profilePicture = document.getElementById('courseImage');
  let newProfilePicture = profilePicture.cloneNode(true);
  profilePicture.parentNode.replaceChild(newProfilePicture, profilePicture);
    if (newProfilePicture.files && newProfilePicture.files[0] && newProfilePicture.files[0].type.match(/^image\//)) {
        console.log(newProfilePicture.files[0])
        let cropModal = document.getElementById('cropModal');
        let newCropModal = cropModal.cloneNode(true);
        cropModal.parentNode.replaceChild(newCropModal, cropModal);
      document.getElementById('cropModal').style.display = 'block';
      let image =  document.getElementById('image')
      image.src = URL.createObjectURL(newProfilePicture.files[0])
      const cropper = new Cropper(image, { aspectRatio: 1 / 1});
      let cropBtn = document.getElementById('cropBtn');
      let newCropBtn = cropBtn.cloneNode(true);
      cropBtn.parentNode.replaceChild(newCropBtn, cropBtn);
      newCropBtn.addEventListener('click', () => {
        let imageURI = cropper.getCroppedCanvas().toDataURL("image/png");
        document.getElementById('imageURI').value = imageURI;
        document.getElementById('cropModal').style.display = 'none';
      });
    }
    }

  window.onload = function () {
    const imageServerError = document.getElementById("imageServerError")
    if (imageServerError) {
      imageServerError.style.display = "block";
    }
  }
</script>
@endsection