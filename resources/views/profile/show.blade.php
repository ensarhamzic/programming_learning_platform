@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
@endsection

@section('content')
<div class="container">
  <div class="card profileCard">
    <div class="card-body">
      <div class="profilePicture">
        <img src="{{ $user->getProfilePicture() }}" alt="Profile picture">
      </div>

      <div class="profileInfo">
        <small>{{ $user->role->name }}</small>
        <h1>{{ $user->name }} {{ $user->surname }}</h1>
        <p><span>@</span>{{ $user->username }}</p>
        @if (Auth::check() && Auth::user()->JMBG == $user->JMBG)
        <a href="{{ route('profile.edit') }}" class="btn btn-primary customBtn">Edit profile</a>
        @endif
      </div>
    </div>
  </div>

  @if ($user->isTeacher())
  <div class="coursesList">
    <div class="coursesInfo">
      <h1>Teaching courses</h1>
      <a href="{{ route('profile.teachingCourses', $user->JMBG) }}">See all</a>
    </div>
    <div class="courses">
      @if ($user->courses->count() > 0)
      @foreach ($user->courses->where('active', 1)->take(3) as $course)
      <div class="card">
        <img src="{{ $course->image }}" class="card-img-top" alt="Course">
        <div class="card-body courseContent">
          <div>
            <h5 class="card-title">{{ $course->title }}</h5>
          </div>

          <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary customBtn">Go to course</a>
        </div>
      </div>
      @endforeach
      @else
      <p class="noCourses">No courses</p>
      @endif
    </div>
  </div>
  @endif

  @if ($user->isStudent())
  <div class="coursesList">
    <div class="coursesInfo">
      <h1>Attends courses</h1>
      <a href="{{ route('profile.attendingCourses', $user->JMBG) }}">See all</a>
    </div>
    <div class="courses">
      @if ($user->attends->count() > 0)
      @foreach ($user->attends->take(3) as $attend)
      @if ($attend->course->active)
      <div class="card">
        <img src="{{ $attend->course->image }}" class="card-img-top" alt="Course">
        <div class="card-body courseContent">
          <div>
            <h5 class="card-title">{{ $attend->course->title }}</h5>
            <p class="card-text">By: {{ $attend->course->user->name }} {{ $attend->course->user->surname }}</p>
          </div>

          <a href="{{ route('courses.show', $attend->course->id) }}" class="btn btn-primary customBtn">Go to course</a>
        </div>
      </div>
      @endif
      @endforeach
      @else
      <p class="noCourses">No courses</p>
      @endif
    </div>
  </div>
  @endif

</div>
@endsection