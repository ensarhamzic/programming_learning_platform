@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/teacher.css') }}" />

<script>
  const deleteClickHandler = (courseId, sectionId) => {
    var url = '{{ route("teacher.courses.deleteSection", [":courseId", ":sectionId"]) }}';
    url = url.replace(':courseId', courseId);
    url = url.replace(':sectionId', sectionId);
    document.getElementById("deleteForm").setAttribute("action", url);
  }
</script>
@endsection

@section('content')
<x-delete-modal title="Delete section" content="Are you sure you want to delete this section?"
  buttonContent="Delete section" />
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Edit Section</div>
        <div class="card-body">
          <form method="POST" action="{{ route('teacher.courses.editSection', [$course->id, $section->id]) }}"
            novalidate id="form">
            @csrf
            @method('PUT')
            <div class="row mb-3">
              <label for="title" class="col-md-4 col-form-label text-md-end">Section Title</label>

              <div class="col-md-6">
                <input id="title" type="title" class="form-control @error('title') is-invalid @enderror" name="title"
                  value="{{ $section->title }}" required autocomplete="title" autofocus>

                @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

                <span class="invalid-feedback" role="alert" id="titleError"></span>
              </div>
            </div>

            <div class="d-flex justify-content-center align-items-center editActions">
              <button type="submit" class="btn btn-primary">
                Edit Section
              </button>
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                onclick="deleteClickHandler({{ $course->id }}, {{ $section->id }})">
                Delete section
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