@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
<div class="banner">
  <img src="{{ asset('images/banner.jpg') }}" alt="image">
  <div class="bannerContent">
    <h1>AsyncLearners</h1>
    <p>Your programming journey starts here!</p>
  </div>
</div>
<div class="container">
  <div class="latestCourses">
    <h1>Discover latest courses</h1>
    <div id="carouselExampleCaptions" class="carousel slide">
      <div class="carousel-indicators">
        @foreach ($courses as $course)
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{ $loop->index }}"
          class="@if ($loop->first) active @endif" aria-current="@if ($loop->first) true @else false @endif"
          aria-label="Slide {{ $loop->index + 1 }}"></button>
        @endforeach
      </div>
      <div class="carousel-inner">
        @foreach ($courses as $course)
        <div class="carousel-item @if ($loop->first) active @endif">
          <a href="{{ route('courses.show', $course->id) }}">
            <img src="{{ $course->image }}" class="d-block w-100" alt="Course">
            <div class="carousel-caption d-none d-md-block">
              <h3>{{ $course->title }}</h3>
              <p>By: {{ $course->user->name }} {{ $course->user->surname }}</p>
            </div>
          </a>
        </div>
        @endforeach

      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>


  <div class="latestCourses">
    <h1>Best rated courses</h1>
    <div id="bestRatedCourses" class="carousel slide">
      <div class="carousel-indicators">
        @foreach ($bestRatedCourses as $course)
        <button type="button" data-bs-target="#bestRatedCourses" data-bs-slide-to="{{ $loop->index }}"
          class="@if ($loop->first) active @endif" aria-current="@if ($loop->first) true @else false @endif"
          aria-label="Slide {{ $loop->index + 1 }}"></button>
        @endforeach
      </div>
      <div class="carousel-inner">
        @foreach ($bestRatedCourses as $course)
        <div class="carousel-item @if ($loop->first) active @endif">
          <a href="{{ route('courses.show', $course->id) }}">
            <img src="{{ $course->image }}" class="d-block w-100" alt="Course">
            <div class="carousel-caption d-none d-md-block">
              <h3>{{ $course->title }}</h3>
              <p>By: {{ $course->user->name }} {{ $course->user->surname }}</p>
              <div class="ratingDiv">
                <span>{{ $course->ratings->avg('rating') ? $course->ratings->avg('rating') : 0 }}</span>
                <div class="ratingStar star-hover">
                  <x-star-icon />
                </div>
                <span class="ratingsCount">({{ $course->ratings->count() }})</span>
              </div>
            </div>
          </a>
        </div>
        @endforeach

      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#bestRatedCourses" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#bestRatedCourses" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <div class="latestNews">
    <h1>Latest news</h1>
    @foreach ($notifications as $notification)
    <div class="card">
      <div class="card-body">
        <h5 class="card-title newsTitle">
          <a class="link link-secondary" href="{{ route('notifications.show', $notification->id) }}">{{
            $notification->title }}</a>
        </h5>
        <p class="card-text newsMessage">{{ $notification->message }}</p>
        <p class="card-text"><small class="text-muted">{{ $notification->created_at }}</small></p>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection