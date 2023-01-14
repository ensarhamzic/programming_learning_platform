@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/course.css') }}" />
@endsection

@section('content')
<div class="course">
  {{-- @auth
  @if (Auth::user()->ownsCourse($course))
  <button>Edit</button>
  @endif
  @endauth --}}
  <h1>{{ $course->title }}</h1>
  <div class="bannerDiv">
    <img src="{{ $course->image }}" alt="Course banner">
  </div>
  <div class="description">
    <p>{{ $course->description }}</p>
  </div>
</div>

@endsection