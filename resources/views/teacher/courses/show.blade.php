@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/course.css') }}" />
@endsection

@section('content')
<div class="course">
  @if(Session::has('success'))
  <div class="alert alert-success">
    {{ Session::get('success') }}
  </div>
  @endif
  @auth
  @if (Auth::user()->ownsCourse($course))
  <div class="teacherActions">
    <a class="btn btn-primary" href="{{ route('teacher.courses.addContent', $course->id) }}">Add Content</a>
    <a class="btn btn-info" href="{{ route('teacher.courses.addSection', $course->id) }}">Add Section</a>
    <a class="btn btn-secondary" href="{{ route('teacher.courses.edit', $course->id) }}">Edit Course</a>
  </div>
  @endif
  @endauth
  <h1>{{ $course->title }}</h1>
  <div class="bannerDiv">
    <img src="{{ $course->image }}" alt="Course banner">
  </div>
  <div class="description">
    <p>
      {{ $course->description }}
    </p>
  </div>
  <hr />
  @auth
  <div class="mainContent">
    <div>
      <h1>Course content</h1>
    </div>
    @foreach ($course->sections as $section)
    <div class="section">
      <div class="sectionTitleDiv">
        <h3>{{ $section->title }}</h3>
        @if (Auth::user()->ownsCourse($course))
        <a href="{{ route('teacher.courses.updateSection', [$course->id, $section->id]) }}">Edit</a>
        @endif
      </div>
      @if ($section->contents->count() > 0)
      @foreach ($section->contents as $content)
      <div class="oneContent">
        <a class="contentLink" href="{{ $content->source }}" target="_blank">
          @if ($content->isPdf())
          <x-pdf-icon />
          @endif
          @if ($content->isImage())
          <x-image-icon />
          @endif
          @if ($content->isVideo())
          <x-video-icon />
          @endif
          @if ($content->isZip())
          <x-zip-icon />
          @endif
          @if ($content->isDocument())
          <x-document-icon />
          @endif
          @if ($content->isLink())
          <x-link-icon />
          @endif
          @if ($content->isPresentation())
          <x-presentation-icon />
          @endif
          {{ $content->title }}
        </a>
        @if (Auth::user()->ownsCourse($course))
        <a href="{{ route('teacher.courses.editContent', [$course->id, $content->id]) }}"
          class="contentActionLink">Edit</a>
        @endif
      </div>
      @endforeach
      @else
      <p>
        <i>No content in this section</i>
      </p>
      @endif
    </div>
    @endforeach
  </div>
  @endauth
</div>

@endsection