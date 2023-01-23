@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/course.css') }}" />

<script>
  function checkHandler(e) {
    this.checked = !this.checked
  }
</script>
@endsection

@section('content')
<div class="container">
  @foreach ($questions as $question)
  <div class="checkQuestion">
    <h1 class="text-center">{{ $question->text }}</h1>
    <div class="answers">
      @foreach ($question->answers->shuffle() as $answer)
      <div class="answer @if($answer->is_correct) correctAnswer @endif">
        @if (in_array($answer->id, $userAnswers->pluck('id')->toArray()))
        <input type="radio" name="question{{ $answer->id }}" id="answer{{ $answer->id }}" value="{{ $answer->id }}"
          onchange="checkHandler.bind(this)()" checked />
        @else
        <input type="radio" name="question{{ $answer->id }}" id="answer{{ $answer->id }}" value="{{ $answer->id }}"
          onclick="checkHandler.bind(this)()" />
        @endif
        <label for="answer{{ $answer->id }}">{{ $answer->text }}</label>
      </div>
      @endforeach

      <div class="points">
        Points:
        @if (in_array($question->getCorrectAnswer()->id, $userAnswers->pluck('id')->toArray()))
        @if($question->getCorrectAnswer()->userUsedHelp($user->JMBG))
        <span> 0.5 (used help)</span>
        @else
        <span> 1</span>
        @endif
        @else
        <span> 0</span>
        @endif
      </div>
    </div>
  </div>
  @endforeach
  <div class="totalPoints">
    Total points: <span>{{ $points }}</span> / {{ count($questions) }}
  </div>
</div>
@endsection