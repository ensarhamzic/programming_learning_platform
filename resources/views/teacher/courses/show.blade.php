@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/course.css') }}" />

<script>
  const deleteClickHandler = (courseId) => {
    var url = '{{ route("courses.unenroll", ":courseId") }}';
    url = url.replace(':courseId', courseId);
    document.getElementById("deleteForm").setAttribute("action", url);
  }

  const cbChange = (e) => {
    let checkBoxes = document.getElementsByClassName("completedCB")
    for(let i = 0; i < checkBoxes.length; i++) {
      checkBoxes[i].checked = true
    }
  }
</script>
@endsection

@section('content')
<x-delete-modal title="Leave course" content="Are you sure you want to leave this course?"
  buttonContent="Leave course" />
<div class="course">
  @if(Session::has('success'))
  <div class="alert alert-success">
    {{ Session::get('success') }}
  </div>
  @endif
  @if(Session::has('error'))
  <div class="alert alert-danger">
    {{ Session::get('error') }}
  </div>
  @endif
  @auth
  @if (Auth::user()->ownsCourse($course))
  <div class="teacherActions">
    @if (!$course->completed)
    <a class="btn btn-primary" href="{{ route('teacher.courses.addContent', $course->id) }}">Add Content</a>
    <a class="btn btn-info" href="{{ route('teacher.courses.addSection', $course->id) }}">Add Section</a>
    <a class="btn btn-secondary" href="{{ route('teacher.courses.edit', $course->id) }}">Edit Course</a>
    @endif
    @if (!$course->completed)
    <form method="POST" action="{{ route('teacher.courses.complete', $course->id) }}">
      @csrf
      <button type="submit" class="btn btn-success">Mark as completed</button>
    </form>
    @else
    <form method="POST" action="{{ route('teacher.courses.incomplete', $course->id) }}">
      @csrf
      <button type="submit" class="btn btn-danger">Mark as not completed</button>
    </form>
    @endif
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
  @if(auth()->check() && (Auth::user()->ownsCourse($course) || Auth::user()->attendsCourse($course)))
  <div class="mainContent">
    <div>
      <h1>Course content</h1>
    </div>
    @foreach ($course->sections as $section)
    <div class="section">
      <div class="sectionTitleDiv">
        <h3>{{ $section->title }}</h3>
        @if (Auth::user()->ownsCourse($course) && !$course->completed)
        <a href="{{ route('teacher.courses.updateSection', [$course->id, $section->id]) }}">Edit</a>
        @endif
      </div>
      @if ($section->contents->count() > 0)
      @foreach ($section->contents as $content)
      <div class="oneContent">
        @if (Auth::user()->attendsCourse($course))
        @if (Auth::user()->completedContent($content))
        <input type="checkbox" name="completed" checked class="completedCB" onchange="cbChange()" />
        @else
        <input type="checkbox" name="completed"
          onclick="javascript:location.href='{{ route('courses.checkQuestion', [$course->id, $content->id]) }}'" />
        @endif

        @endif
        <a class=" contentLink" href="{{ $content->source }}" target="_blank">
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
        @if (Auth::user()->ownsCourse($course) && !$course->completed)
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
    @if (Auth::user()->attendsCourse($course))
    @if (Auth::user()->doneTest($course))
    <a href="{{ route('courses.test.results', $course->id) }}" class="btn btn-secondary">See test results</a>
    @else
    <a href="{{ route('courses.test', $course->id) }}" class="btn btn-secondary">Take course test</a>
    @endif
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
      onclick="deleteClickHandler({{ $course->id }})">Leave this course</button>
    @endif
  </div>
  @elseif (auth()->guest() || (Auth::user()->isStudent()))
  <div class="alert alert-danger text-center notEnrolled">
    <p>
      You need to be enrolled in this course to see its content
    </p>
    <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
      @csrf
      <button type="submit" class="btn btn-secondary">Join this course</button>
    </form>

  </div>


  @endif
</div>

@endsection