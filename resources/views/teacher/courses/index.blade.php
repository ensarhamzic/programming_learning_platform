@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/teacher.css') }}" />
<script>
  const deleteClickHandler = (id) => {
    var url = '{{ route("teacher.courses.destroy", ":id") }}';
    url = url.replace(':id', id);
    document.getElementById("deleteForm").setAttribute("action", url);
  }
</script>
@endsection

@section('content')
<x-delete-modal title="Delete course" content="Are you sure you want to delete this course?"
  buttonContent="Delete course" />

<div class="container">
  <div class="activeCourses">
    <h1>Your active courses</h1>
    <div class="activeCoursesList">
      @if (count($activeCourses) == 0)
      <p class='noCourses'>There are no active courses</p>
      @else
      @foreach ($activeCourses as $course)
      <div class="course">
        <div>
          <div class="courseBanner">
            <img src="{{ $course->image }}" alt="Course banner">
          </div>
          <div class="courseTitle">
            <h2>{{ $course->title }}</h2>
          </div>
          <div class="courseDescription">
            <p>{{ $course->description }}</p>
          </div>
        </div>
        <div class="courseOptions">
          <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary">View course</a>
          <form method="POST" action="{{ route('teacher.courses.toggleActive', $course->id) }}">
            @csrf
            <button class="btn btn-info">Make inactive</button>
          </form>
        </div>
      </div>
      @endforeach
      @endif
    </div>
  </div>

  <div class="inactiveCourses">
    <h1>Your inactive courses</h1>
    <div class="inactiveCoursesList">
      @if (count($inactiveCourses) == 0)
      <p class='noCourses'>There are no inactive courses</p>
      @else
      @foreach ($inactiveCourses as $course)
      <div class="course">
        <div>
          <div class="courseBanner">
            <img src="{{ $course->image }}" alt="Course banner">
          </div>
          <div class="courseTitle">
            <h2>{{ $course->title }}</h2>
          </div>
          <div class="courseDescription">
            <p>{{ $course->description }}</p>
          </div>
        </div>
        <div class="courseOptions">
          <form method="POST" action="{{ route('teacher.courses.toggleActive', $course->id) }}">
            @csrf
            <button class="btn btn-info">Make active</button>
          </form>
          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
            onclick="deleteClickHandler({{ $course->id }})">Delete Course</button>
        </div>
      </div>
      @endforeach
      @endif
    </div>
  </div>
  @endsection