@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/course.css') }}" />

<script>
  const helpHandler = async (questionId) => {
    const url = '{{ route("test.help", ":questionId") }}';
    const newUrl = url.replace(':questionId', questionId);
    const response = await fetch(newUrl);
    const data = await response.json();
    const questionIds = [data.correct.id, data.incorrect.id]
    const inputs = document.getElementsByName(`question${questionId}`);
    let ids = Array.from(inputs).map((input) => input.id);
    ids = ids.map((id) => parseInt(id.replace('answer', '')));
    const filteredIds = ids.filter((id) => questionIds.includes(id));

    inputs.forEach((input) => {
      if (!filteredIds.includes(parseInt(input.id.replace('answer', '')))) {
        input.disabled = true;
      }
    });

    const helpButton = document.querySelector(`input[name="help${questionId}"]`);
    helpButton.value = 1;

    const helpDiv = document.querySelector(`#helpDiv${questionId}`);
    helpDiv.remove();

    // uncheck all inputs
    inputs.forEach((input) => {
      input.checked = false;
    });

    // check just first input that is not disabled
    const firstInput = Array.from(inputs).find((input) => !input.disabled);
    firstInput.checked = true;
    

  }
</script>
@endsection

@section('content')
<form method="POST" action="{{ route('courses.test.end', $course->id) }}">
  @csrf
  @foreach ($questions as $question)

  <div class="checkQuestion">
    <h1 class="text-center">{{ $question->text }}</h1>
    <div class="answers">
      @foreach ($question->answers as $answer)
      <div class=" answer">
        @if ($loop->first)
        <input type="radio" name="question{{ $question->id }}" id="answer{{ $answer->id }}" value="{{ $answer->id }}"
          checked />
        @else
        <input type="radio" name="question{{ $question->id }}" id="answer{{ $answer->id }}"
          value="{{ $answer->id }} " />
        @endif

        <label for="answer{{ $answer->id }}">{{ $answer->text }}</label>
      </div>
      @endforeach
      <input type="hidden" name="help{{ $question->id }}" value="0" />
      <div class="help d-flex justify-content-end" id="helpDiv{{ $question->id }}">
        <button class="btn btn-success customBtn" type="button" onclick="helpHandler({{ $question->id }})">
          Get help
        </button>
      </div>
    </div>
  </div>
  @endforeach
  <div class="d-flex justify-content-center">
    <button class="btn btn-primary customBtn" type="submit">End Test</button>
  </div>
</form>
@endsection