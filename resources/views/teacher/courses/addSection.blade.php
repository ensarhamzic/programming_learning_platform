@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/teacher.css') }}" />
@endsection

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add Course Section</div>
        <div class="card-body">
          <form method="POST" action="{{ route('teacher.courses.addSection', $courseId) }}" novalidate id="form">
            @csrf
            <div class="row mb-3">
              <label for="title" class="col-md-4 col-form-label text-md-end">Section Title</label>

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

            <div class="d-flex justify-content-center align-items-center">
              <button type="submit" class="btn btn-primary customBtn">
                Add Section
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
        
        if(title.value.trim().length < 1) {
            titleError.innerHTML = "Title must not be empty";
            titleError.style.display = "block";
            formValid = false;
        } else {
            titleError.style.display = "none";
        }

        if(formValid) {
            this.submit();
        }
         
    }
</script>
@endsection