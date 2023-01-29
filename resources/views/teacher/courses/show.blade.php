@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/course.css') }}" />

<script>
  const unenrollClickHandler = (courseId) => {
    var url = '{{ route("courses.unenroll", ":courseId") }}';
    url = url.replace(':courseId', courseId);
    document.getElementById("deleteForm").setAttribute("action", url);
  }

  const deleteCourseHandler = (courseId) => {
    var url = '{{ route("admin.courses.delete", ":courseId") }}';
    url = url.replace(':courseId', courseId);
    document.getElementById("courseDeleteForm").setAttribute("action", url);
  }

  const deleteSectionHandler = (courseId, sectionId) => {
    var url = '{{ route("admin.courses.deleteSection", [":courseId", ":sectionId"]) }}';
    url = url.replace(':courseId', courseId);
    url = url.replace(':sectionId', sectionId);
    document.getElementById("sectionDeleteForm").setAttribute("action", url);
  }

  const deleteContentHandler = (courseId, contentId) => {
    var url = '{{ route("admin.courses.deleteContent", [":courseId", ":contentId"]) }}';
    url = url.replace(':courseId', courseId);
    url = url.replace(':contentId', contentId);
    document.getElementById("contentDeleteForm").setAttribute("action", url);
  }

  const rateClickHandler = (courseId) => {
    var url = '{{ route("courses.rate", ":courseId") }}';
    url = url.replace(':courseId', courseId);
    document.getElementById("rateForm").setAttribute("action", url);
  }

  const cbChange = (e) => {
    let checkBoxes = document.getElementsByClassName("completedCB")
    for(let i = 0; i < checkBoxes.length; i++) {
      checkBoxes[i].checked = true
    }
  }

  const starClickHandler = (rating) => {
    let ratingInput = document.getElementById("rating")
    ratingInput.value = rating
  }

  const starOverHandler = (rating) => {
    let stars = document.getElementsByClassName("star")
    for(let i = 0; i < stars.length; i++) {
      stars[i].classList.remove("star-hover")
    }
    for(let i = 0; i < rating; i++) {
      stars[i].classList.add("star-hover")
    }
  }

  const starOutHandler = () => {
    let stars = document.getElementsByClassName("star")
    let rating = document.getElementById("rating").value
    for(let i = 0; i < stars.length; i++) {
      stars[i].classList.remove("star-hover")
    }
    for(let i = 0; i < rating; i++) {
      stars[i].classList.add("star-hover")
    }
  }


</script>
@endsection

@section('content')
<x-delete-modal title="Leave course" content="Are you sure you want to leave this course?"
  buttonContent="Leave course" />
<x-delete-modal modalId="sectionDeleteModal" formId="sectionDeleteForm" title="Delete Section"
  content="Are you sure you want to delete this section?" buttonContent="Delete Section" />
<x-delete-modal modalId="contentDeleteModal" formId="contentDeleteForm" title="Delete Content"
  content="Are you sure you want to delete this content?" buttonContent="Delete Content" />
<x-delete-modal modalId="courseDeleteModal" formId="courseDeleteForm" title="Delete Course"
  content="Are you sure you want to delete this course?" buttonContent="Delete Course" />
<div class="modal fade" id="rateModal" tabindex="-1" aria-labelledby="rateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rateModalLabel">Rate this course</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <h3>Rate this course from 1 to 5 stars</h3>
        <div class="stars">
          <div onclick="starClickHandler(1)" class="star" onmouseover="starOverHandler(1)"
            onmouseout="starOutHandler()">
            <x-star-icon />
          </div>
          <div onclick="starClickHandler(2)" class="star" onmouseover="starOverHandler(2)"
            onmouseout="starOutHandler()">
            <x-star-icon />
          </div>
          <div onclick="starClickHandler(3)" class="star" onmouseover="starOverHandler(3)"
            onmouseout="starOutHandler()">
            <x-star-icon />
          </div>
          <div onclick="starClickHandler(4)" class="star" onmouseover="starOverHandler(4)"
            onmouseout="starOutHandler()">
            <x-star-icon />
          </div>
          <div onclick="starClickHandler(5)" class="star" onmouseover="starOverHandler(5)"
            onmouseout="starOutHandler()">
            <x-star-icon />
          </div>

        </div>
        <span class="starsError text-center text-danger" id="starsError"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form method="POST" id="rateForm">
          @csrf
          <input type="hidden" name="rating" id="rating" value="{{ $userRating ? $userRating->rating : 0 }}" />
          <button class="btn btn-success customBtn">Rate</button>
        </form>
      </div>
    </div>
  </div>
</div>
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
    <a class="btn btn-primary customBtn" href="{{ route('teacher.courses.addContent', $course->id) }}">Add Content</a>
    <a class="btn btn-info customBtn" href="{{ route('teacher.courses.addSection', $course->id) }}">Add Section</a>
    <a class="btn btn-secondary customBtn" href="{{ route('teacher.courses.edit', $course->id) }}">Edit Course</a>
    @endif
    @if (!$course->completed)
    <form method="POST" action="{{ route('teacher.courses.complete', $course->id) }}">
      @csrf
      <button type="submit" class="btn btn-success customBtn">Mark as completed</button>
    </form>
    @else
    <form method="POST" action="{{ route('teacher.courses.incomplete', $course->id) }}">
      @csrf
      <button type="submit" class="btn btn-danger customBtn">Mark as not completed</button>
    </form>
    @endif
    <a class="btn btn-info customBtn" href="{{ route('teacher.courses.attendants', $course->id) }}">See course
      attendants</a>
  </div>
  @endif
  @endauth

  <div class="courseTitle">
    <h1>{{ $course->title }}</h1>

    <div class="courseOwner">
      <div>
        <a href="{{ route('profile.show', $course->user->JMBG) }}"><img src={{ $course->user->getProfilePicture() }}
          alt="Profile picture" /> </a>
      </div>
      <div>
        <a href="{{ route('profile.show', $course->user->JMBG) }}">
          <p>{{ $course->user->name }} {{ $course->user->surname }}</p>
        </a>
      </div>
    </div>

  </div>

  <div class="bannerDiv">
    <img src="{{ $course->image }}" alt="Course banner">
  </div>
  <div class="usersRating">
    <h3>Average course rating</h3>
    <div class="ratingDiv">
      <span>{{ $course->ratings->avg('rating') ? $course->ratings->avg('rating') : 0 }}</span>
      <div class="ratingStar star-hover">
        <x-star-icon />
      </div>
      <span class="ratingsCount">({{ $course->ratings->count() }})</span>
    </div>
  </div>

  @if (Auth::check() && Auth::user()->isAdmin())
  <div class="deleteCourseAdminButton">
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#courseDeleteModal"
      onclick="deleteCourseHandler({{ $course->id }})">Delete Course</button>
  </div>
  @endif
  <div class="description">
    <p>
      {{ $course->description }}
    </p>
  </div>
  <hr />
  @if(auth()->check() && (Auth::user()->ownsCourse($course) || Auth::user()->attendsCourse($course) ||
  Auth::user()->isAdmin()))
  <div class="mainContent">
    <div>
      <h1>Course content</h1>
    </div>
    @if ($course->sections->count() > 0)
    @foreach ($course->sections as $section)
    <div class="section">
      <div class="sectionTitleDiv">
        <h3>{{ $section->title }}</h3>
        <div>
          @if (Auth::user()->ownsCourse($course) && !$course->completed)
          <a href="{{ route('teacher.courses.addContent', [$course->id, 'section=' . $section->id]) }}">Add Content</a>
          <a href="{{ route('teacher.courses.updateSection', [$course->id, $section->id]) }}">Edit</a>
          @endif
          @if ( Auth::check() && Auth::user()->isAdmin())
          <button class="deleteButton" data-bs-toggle="modal" data-bs-target="#sectionDeleteModal"
            onclick="deleteSectionHandler({{ $course->id }}, {{ $section->id }})">Delete</button>
          @endif
        </div>
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
        @if ( Auth::check() && Auth::user()->isAdmin())
        <button class="deleteButton" data-bs-toggle="modal" data-bs-target="#contentDeleteModal"
          onclick="deleteContentHandler({{ $course->id }}, {{ $content->id }})">Delete</button>
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

    @else
    <p class="text-center">
      <i>No content in this course yet</i>
    </p>
    @endif
    @if (Auth::user()->attendsCourse($course))
    <div class="d-flex justify-content-center gap-3 flex-wrap">
      @if (Auth::user()->doneTest($course))
      <a href="{{ route('courses.test.results', $course->id) }}" class="btn btn-secondary customBtn">See test
        results</a>
      @else
      <a href="{{ route('courses.test', $course->id) }}" class="btn btn-secondary customBtn">Take course test</a>
      @endif
      <button type="button" class="btn btn-info customBtn" data-bs-toggle="modal" data-bs-target="#rateModal"
        onclick="rateClickHandler({{ $course->id }})">Rate this course</button>
      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
        onclick="unenrollClickHandler({{ $course->id }})">Leave this course</button>
      @endif
    </div>
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


@section('scripts')
<script>
  document.getElementById('rateForm').onsubmit = function(e) {
e.preventDefault()
let rating = document.getElementById("rating").value
if(rating == 0 || !rating) {
document.getElementById("starsError").innerHTML = "Please select a rating"
return
}
this.submit()
}

window.onload = function() {
  let stars = document.getElementsByClassName("star")
    let rating = document.getElementById("rating").value
    for(let i = 0; i < stars.length; i++) {
      stars[i].classList.remove("star-hover")
    }
    for(let i = 0; i < rating; i++) {
      stars[i].classList.add("star-hover")
    }
}
</script>
@endsection