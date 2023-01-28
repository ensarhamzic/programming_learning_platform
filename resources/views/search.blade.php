@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
<div class="container">
  <h1>Search results for: {{ $search }}</h1>
  <h2>Courses</h2>
  <div class="foundCourses">
    @if ($courses->count() > 0)
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
    @else
    <p>No courses found</p>
    @endif
  </div>

  <hr />

  <h2>Teachers</h2>
  <div class="foundUsers">
    @if ($teachers->count() > 0)
    @foreach ($teachers as $user)
    <div class="card" style="width: 18rem;">
      <img src="{{ $user->getProfilePicture() }}" alt="User">
      <div class="card-body foundUserContent">
        <div>
          <h5 class="card-title">{{ $user->name }} {{ $user->surname }}</h5>
          <p class="card-text">{{ $user->email }}</p>
        </div>

        <a href="{{ route('profile.show', $user->JMBG) }}" class="btn btn-primary customBtn">Go to profile</a>
      </div>
    </div>
    @endforeach
    @else
    <p>No users found</p>
    @endif
  </div>

  <hr />

  <h2>Students</h2>
  <div class="foundUsers">
    @if ($students->count() > 0)
    @foreach ($students as $user)
    <div class="card" style="width: 18rem;">
      <img src="{{ $user->getProfilePicture() }}" alt="User">
      <div class="card-body foundUserContent">
        <div>
          <h5 class="card-title">{{ $user->name }} {{ $user->surname }}</h5>
          <p class="card-text">{{ $user->email }}</p>
        </div>

        <a href="{{ route('profile.show', $user->JMBG) }}" class="btn btn-primary customBtn">Go to profile</a>
      </div>
    </div>
    @endforeach
    @else
    <p>No users found</p>
    @endif

  </div>
  @endsection