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
      <button class="btn btn-success cropBtn" id="cropBtn">Crop image</button>
    </div>
  </div>
</div>



<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Create New Course</div>
        <div class="card-body">
          <form method="POST" action="{{ route('teacher.courses.store') }}">
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
              </div>
            </div>

            <div class="row mb-3">
              <label for="description" class="col-md-4 col-form-label text-md-end">Course Banner</label>

              <div class="col-md-6">
                <input id="courseImage" type="file" class="form-control @error('courseImage') is-invalid @enderror"
                  name="courseImage" required rows="10" autocomplete="current-courseImage"
                  accept="image/png, image/jpeg, image/jpg" />

                @error('courseImage')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <input type="hidden" name="imageURI" value="" id="imageURI" />

            <div class="d-flex justify-content-center align-items-center">
              <button type="submit" class="btn btn-primary">
                Create Course
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
  let courseImage = document.getElementById('courseImage');
  let newCourseImage = courseImage.cloneNode(true);
  courseImage.parentNode.replaceChild(newCourseImage, courseImage);
  newCourseImage.addEventListener('change', function () {
    if (this.files && this.files[0] && this.files[0].type.match(/^image\//)) {
      document.getElementById('cropModal').style.display = 'block';
      let image =  document.getElementById('image')
      image.src = URL.createObjectURL(this.files[0])
      const cropper = new Cropper(image, { aspectRatio: 16 / 9});
      let cropBtn = document.getElementById('cropBtn');
      let newCropBtn = cropBtn.cloneNode(true);
      cropBtn.parentNode.replaceChild(newCropBtn, cropBtn);
      newCropBtn.addEventListener('click', () => {
        let imageURI = cropper.getCroppedCanvas().toDataURL("image/png");
        document.getElementById('imageURI').value = imageURI;
        document.getElementById('cropModal').style.display = 'none';
      });
    }
  });

</script>
@endsection