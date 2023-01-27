@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/teacher.css') }}" />
<script>
  const linkCbChange = () => {
    let content = document.getElementById('content');
    let linkCheckBox = document.getElementById('onlyLink');
    let link = document.getElementById('link');
    if (linkCheckBox.checked) {
      content.disabled = true;
      link.disabled = false;
    } else {
      content.disabled = false;
      link.disabled = true;
    }
  }

  const deleteClickHandler = (courseId, contentId) => {
    var url = '{{ route("teacher.courses.deleteContent", [":courseId", ":contentId"]) }}';
    url = url.replace(':courseId', courseId);
    url = url.replace(':contentId', contentId);
    document.getElementById("deleteForm").setAttribute("action", url);
  }
</script>
@endsection

@section('content')
<x-delete-modal title="Delete content" content="Are you sure you want to delete this content?"
  buttonContent="Delete content" />
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add Course Content</div>
        <div class="card-body">
          <form method="POST" action="{{ route('teacher.courses.updateContent', [$course->id, $content->id]) }}"
            novalidate id="form" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-3">
              <label for="section" class="col-md-4 col-form-label text-md-end">Section</label>

              <div class="col-md-6">
                <select name="section" id="section" class="form-control @error('section') is-invalid @enderror">
                  @foreach ($course->sections as $section)
                  @if ($section->id == $content->section_id)
                  <option value="{{ $section->id }}" checked>{{ $section->title }}</option>
                  @else
                  <option value="{{ $section->id }}">{{ $section->title }}</option>
                  @endif
                  @endforeach
                </select>

                @error('section')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>


            <div class="row mb-3">
              <label for="title" class="col-md-4 col-form-label text-md-end">Content Title</label>

              <div class="col-md-6">
                <input id="title" type="title" class="form-control @error('title') is-invalid @enderror" name="title"
                  value="{{ $content->title }}" required autocomplete="title" autofocus>

                @error('title')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

                <span class="invalid-feedback" role="alert" id="titleError"></span>
              </div>
            </div>

            {{-- <div class="row mb-3">
              <label class="col-md-4 col-form-label text-md-end">Current content</label>

              <div class="col-md-6">
                <a href="{{ $content->source }}">{{ $content->title }}</a>
              </div>
            </div> --}}

            <div class="row mb-3">
              <label for="content" class="col-md-4 col-form-label text-md-end">Content</label>

              <div class="col-md-6">
                <input id="content" type="file" class="form-control @error('content') is-invalid @enderror"
                  name="content" required rows="10" autocomplete="current-content" />

                @error('imageURI')
                <span class="invalid-feedback" role="alert" id="imageServerError">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

                <span class="invalid-feedback" role="alert" id="contentError"></span>
                <p><i>leave empty to not change</i></p>
              </div>
            </div>

            <div class="row mb-1">
              <label for="onlyLink" class="col-md-4 col-form-label text-md-end">Post just link</label>

              <div class="col-md-6 linkDiv">
                <input id="onlyLink" name="onlyLink" type="checkbox" required autocomplete="current-content"
                  onchange="linkCbChange()" />
                <input id="link" type="text" class="form-control @error('link') is-invalid @enderror" name="link"
                  value="{{ old('link') }}" autocomplete="link" autofocus placeholder="https://www.example.com/article"
                  disabled />
              </div>
              <p class="text-center m-0"><i>leave empty to not change</i></p>

            </div>
            <div class="d-flex justify-content-center text-center">
              <span class="invalid-feedback" role="alert" id="linkError"></span>
            </div>


            <input type="hidden" name="contentType" value="" id="contentType" />


            <div class="row mb-3 mt-2">
              <label for="checkQuestion" class="col-md-4 col-form-label text-md-end">Check Question</label>

              <div class="col-md-6">
                <textarea id="checkQuestion" class="form-control @error('checkQuestion') is-invalid @enderror"
                  name="checkQuestion" required
                  autocomplete="current-checkQuestion">{{ $checkQuestion->text }}</textarea>
                <div class="testQuestionInfo">
                  <p><i>This question is used
                      to determine users knowledge of the course and display matching test difficulty</i></p>
                </div>

                <div class="mb-1 correctAnswer">
                  <input class="form-control" type="text" name="checkQuestionAnswers[]" id="checkQuestionAnswer"
                    placeholder="Answer 1: Correct answer" value="{{ $checkQuestion->answers[0]->text }}" />
                </div>

                <div class="mb-1 incorrectAnswer">
                  <input class="form-control" type="text" name="checkQuestionAnswers[]" id="checkQuestionAnswer"
                    placeholder="Answer 2: Incorrect answer" value="{{ $checkQuestion->answers[1]->text }}" />
                </div>

                <div class="mb-1 incorrectAnswer">
                  <input class="form-control" type="text" name="checkQuestionAnswers[]" id="checkQuestionAnswer"
                    placeholder="Answer 3: Incorrect answer" value="{{ $checkQuestion->answers[2]->text }}" />
                </div>

                <div class="mb-1 incorrectAnswer">
                  <input class="form-control" type="text" name="checkQuestionAnswers[]" id="checkQuestionAnswer"
                    placeholder="Answer 4: Incorrect answer" value="{{ $checkQuestion->answers[3]->text }}" />
                </div>


                @error('checkQuestion')
                <span class="invalid-feedback" role="alert" id="checkQuestionError">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

                <span class="invalid-feedback" role="alert" id="checkQuestionError"></span>
              </div>
            </div>


            <div class="row mb-3">
              <label for="easyQuestion" class="col-md-4 col-form-label text-md-end">Easy Question</label>

              <div class="col-md-6">
                <textarea id="easyQuestion" class="form-control mb-2 @error('easyQuestion') is-invalid @enderror"
                  name="easyQuestion" required autocomplete="current-easyQuestion">{{ $easyQuestion->text }}</textarea>

                <div class="mb-1 correctAnswer">
                  <input class="form-control" type="text" name="easyQuestionAnswers[]" id="easyQuestionAnswer"
                    placeholder="Answer 1: Correct answer" value="{{ $easyQuestion->answers[0]->text }}" />
                </div>

                <div class="mb-1 incorrectAnswer">
                  <input class="form-control" type="text" name="easyQuestionAnswers[]" id="easyQuestionAnswer"
                    placeholder="Answer 2: Incorrect answer" value="{{ $easyQuestion->answers[1]->text }}" />
                </div>

                <div class="mb-1 incorrectAnswer">
                  <input class="form-control" type="text" name="easyQuestionAnswers[]" id="easyQuestionAnswer"
                    placeholder="Answer 3: Incorrect answer" value="{{ $easyQuestion->answers[2]->text }}" />
                </div>

                <div class="mb-1 incorrectAnswer">
                  <input class="form-control" type="text" name="easyQuestionAnswers[]" id="easyQuestionAnswer"
                    placeholder="Answer 4: Incorrect answer" value="{{ $easyQuestion->answers[3]->text }}" />
                </div>


                @error('easyQuestion')
                <span class="invalid-feedback" role="alert" id="easyQuestionError">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

                <span class="invalid-feedback" role="alert" id="easyQuestionError"></span>
              </div>
            </div>

            <div class="row mb-3">
              <label for="mediumQuestion" class="col-md-4 col-form-label text-md-end">Medium Question</label>

              <div class="col-md-6">
                <textarea id="mediumQuestion" class="form-control mb-2 @error('mediumQuestion') is-invalid @enderror"
                  name="mediumQuestion" required
                  autocomplete="current-mediumQuestion">{{ $mediumQuestion->text }}</textarea>

                <div class="mb-1 correctAnswer">
                  <input class="form-control" type="text" name="mediumQuestionAnswers[]" id="mediumQuestionAnswer"
                    placeholder="Answer 1: Correct answer" value="{{ $mediumQuestion->answers[0]->text }}" />
                </div>

                <div class="mb-1 incorrectAnswer">
                  <input class="form-control" type="text" name="mediumQuestionAnswers[]" id="mediumQuestionAnswer"
                    placeholder="Answer 2: Incorrect answer" value="{{ $mediumQuestion->answers[1]->text }}" />
                </div>

                <div class="mb-1 incorrectAnswer">
                  <input class="form-control" type="text" name="mediumQuestionAnswers[]" id="mediumQuestionAnswer"
                    placeholder="Answer 3: Incorrect answer" value="{{ $mediumQuestion->answers[2]->text }}" />
                </div>

                <div class="mb-1 incorrectAnswer">
                  <input class="form-control" type="text" name="mediumQuestionAnswers[]" id="mediumQuestionAnswer"
                    placeholder="Answer 4: Incorrect answer" value="{{ $mediumQuestion->answers[3]->text }}" />
                </div>


                @error('mediumQuestion')
                <span class="invalid-feedback" role="alert" id="mediumQuestionError">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <span class="invalid-feedback" role="alert" id="mediumQuestionError"></span>
              </div>
            </div>

            <div class="row mb-3">
              <label for="hardQuestion" class="col-md-4 col-form-label text-md-end">Hard Question</label>

              <div class="col-md-6">
                <textarea id="hardQuestion" class="form-control mb-2 @error('hardQuestion') is-invalid @enderror"
                  name="hardQuestion" required autocomplete="current-hardQuestion">{{ $hardQuestion->text }}</textarea>

                <div class="mb-1 correctAnswer">
                  <input class="form-control" type="text" name="hardQuestionAnswers[]" id="hardQuestionAnswer"
                    placeholder="Answer 1: Correct answer" value="{{ $hardQuestion->answers[0]->text }}" />
                </div>

                <div class="mb-1 incorrectAnswer">
                  <input class="form-control" type="text" name="hardQuestionAnswers[]" id="hardQuestionAnswer"
                    placeholder="Answer 2: Incorrect answer" value="{{ $hardQuestion->answers[1]->text }}" />
                </div>

                <div class="mb-1 incorrectAnswer">
                  <input class="form-control" type="text" name="hardQuestionAnswers[]" id="hardQuestionAnswer"
                    placeholder="Answer 3: Incorrect answer" value="{{ $hardQuestion->answers[2]->text }}" />
                </div>

                <div class="mb-1 incorrectAnswer">
                  <input class="form-control" type="text" name="hardQuestionAnswers[]" id="hardQuestionAnswer"
                    placeholder="Answer 4: Incorrect answer" value="{{ $hardQuestion->answers[3]->text }}" />
                </div>


                @error('hardQuestion')
                <span class="invalid-feedback" role="alert" id="hardQuestionError">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

                <span class="invalid-feedback" role="alert" id="hardQuestionError"></span>
              </div>
            </div>


            <div class="d-flex justify-content-center align-items-center editActions">
              <button type="submit" class="btn btn-primary customBtn">
                Edit Content
              </button>
              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                onclick="deleteClickHandler({{ $course->id }}, {{ $content->id }})">
                Delete Content
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

        let content = document.getElementById('content');
        let contentError = document.getElementById('contentError');

        let linkCheckBox = document.getElementById('onlyLink');
        let link = document.getElementById('link');
        let linkError = document.getElementById('linkError');

        let contentType = document.getElementById('contentType');

        let checkQuestion = document.getElementById('checkQuestion');
        let checkQuestionError = document.getElementById('checkQuestionError');
        let checkQuestionAnswers = document.getElementsByName('checkQuestionAnswers[]');
        let easyQuestion = document.getElementById('easyQuestion');
        let easyQuestionError = document.getElementById('easyQuestionError');
        let easyQuestionAnswers = document.getElementsByName('easyQuestionAnswers[]');
        let mediumQuestion = document.getElementById('mediumQuestion');
        let mediumQuestionError = document.getElementById('mediumQuestionError');
        let mediumQuestionAnswers = document.getElementsByName('mediumQuestionAnswers[]');
        let hardQuestion = document.getElementById('hardQuestion');
        let hardQuestionError = document.getElementById('hardQuestionError');
        let hardQuestionAnswers = document.getElementsByName('hardQuestionAnswers[]');



        titleError.style.display = "none";
        contentError.style.display = "none";
        linkError.style.display = "none";
        checkQuestionError.style.display = "none";
        easyQuestionError.style.display = "none";
        mediumQuestionError.style.display = "none";
        hardQuestionError.style.display = "none";


        
        if(title.value.trim().length < 1) {
            titleError.innerHTML = "Title must not be empty";
            titleError.style.display = "block";
            formValid = false;
        } else {
            titleError.style.display = "none";
        }



        let fileValid = true;
        
        if(content.files && content.files.length > 0) {
          const file = content.files[0];
          const fileType = file.type;
          if(fileType.startsWith('image/')) {
            contentType.value = 'image';
          } else if(fileType.startsWith('video/')) {
            contentType.value = 'video';
          } else if(fileType === 'application/pdf') {
            contentType.value = 'pdf';
          } else if(fileType === 'application/vnd.ms-powerpoint'
          || fileType === 'application/vnd.openxmlformats-officedocument.presentationml.presentation') {
            contentType.value = 'presentation';
          } else if(fileType === 'application/msword' || fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
            contentType.value = 'document';
          } else if(fileType === 'application/x-rar-compressed' || fileType === 'application/octet-stream' || fileType === 'application/x-zip-compressed') {
            contentType.value = 'zip';
          } else {
            formValid = false;
            fileValid = false;
          }

          if (!fileValid) {
            contentError.innerHTML = "Content must be a video, pdf, powerpoint presentation, ms word document or zip file";
            contentError.style.display = "block";
            formValid = false;
          } else {
            contentError.style.display = "none";
          }
        }

        if(linkCheckBox.checked) {
          if(link.value.trim().length < 1) {
            linkError.innerHTML = "Link must not be empty";
            linkError.style.display = "block";
            formValid = false;
          } else {
            linkError.style.display = "none";
            contentType.value = 'link';
          }
        }

        if(checkQuestion.value.trim().length < 1) {
            checkQuestionError.innerHTML = "Check question must not be empty";
            checkQuestionError.style.display = "block";
            formValid = false;
        } else {
          // check if all answers are filled
          let allAnswersFilled = true;
          for (let i = 0; i < checkQuestionAnswers.length; i++) {
            if (checkQuestionAnswers[i].value.trim().length < 1) {
              allAnswersFilled = false;
              break;
            }
          }
          if (!allAnswersFilled) {
            checkQuestionError.innerHTML = "All answers must be filled";
            checkQuestionError.style.display = "block";
            formValid = false;
          } else {
            checkQuestionError.style.display = "none";
          }
        }

        if(easyQuestion.value.trim().length < 1) {
            easyQuestionError.innerHTML = "Easy question must not be empty";
            easyQuestionError.style.display = "block";
            formValid = false;
        } else {
          // check if all answers are filled
          let allAnswersFilled = true;
          for (let i = 0; i < easyQuestionAnswers.length; i++) {
            if (easyQuestionAnswers[i].value.trim().length < 1) {
              allAnswersFilled = false;
              break;
            }
          }
          if (!allAnswersFilled) {
            easyQuestionError.innerHTML = "All answers must be filled";
            easyQuestionError.style.display = "block";
            formValid = false;
          } else {
            easyQuestionError.style.display = "none";
          }
        }

        if(mediumQuestion.value.trim().length < 1) {
            mediumQuestionError.innerHTML = "Medium question must not be empty";
            mediumQuestionError.style.display = "block";
            formValid = false;
        } else {
          // check if all answers are filled
          let allAnswersFilled = true;
          for (let i = 0; i < mediumQuestionAnswers.length; i++) {
            if (mediumQuestionAnswers[i].value.trim().length < 1) {
              allAnswersFilled = false;
              break;
            }
          }
          if (!allAnswersFilled) {
            mediumQuestionError.innerHTML = "All answers must be filled";
            mediumQuestionError.style.display = "block";
            formValid = false;
          } else {
            mediumQuestionError.style.display = "none";
          }
        }

        if(hardQuestion.value.trim().length < 1) {
            hardQuestionError.innerHTML = "Hard question must not be empty";
            hardQuestionError.style.display = "block";
            formValid = false;
        } else {
          // check if all answers are filled
          let allAnswersFilled = true;
          for (let i = 0; i < hardQuestionAnswers.length; i++) {
            if (hardQuestionAnswers[i].value.trim().length < 1) {
              allAnswersFilled = false;
              break;
            }
          }
          if (!allAnswersFilled) {
            hardQuestionError.innerHTML = "All answers must be filled";
            hardQuestionError.style.display = "block";
            formValid = false;
          } else {
            hardQuestionError.style.display = "none";
          }
        }

        if(formValid) {
            this.submit();
        }
         
    }
</script>
@endsection