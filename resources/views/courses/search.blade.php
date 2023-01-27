@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/course.css') }}" />
@endsection

@section('content')
<div class="container">
  <h1>Search results for: {{ $search }}</h1>
  <div class="foundCourses">
    @foreach ($courses as $course)
    <div class="card" style="width: 18rem;">
      <img src="{{ $course->image }}" class="card-img-top" alt="Course">
      <div class="card-body foundCourseContent">
        <div>
          <h5 class="card-title">{{ $course->title }}</h5>
          <p class="card-text">By: {{ $course->user->name }} {{ $course->user->surname }}</p>
        </div>

        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary customBtn">Go to course</a>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection