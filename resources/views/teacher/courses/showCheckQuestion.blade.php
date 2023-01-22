@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/course.css') }}" />
@endsection

@section('content')
<div class="checkQuestion">
  <h1 class="text-center">{{ $question->text }}</h1>
  <div class="answers">
    <form method="POST" action="{{ route('courses.questions.answer', [$course->id, $content->id, $question->id]) }}">
      @csrf
      @foreach ($question->answers as $answer)
      <div class=" answer">
        @if ($loop->first)
        <input type="radio" name="answer" id="answer{{ $answer->id }}" value="{{ $answer->id }}" checked />
        @else
        <input type="radio" name="answer" id="answer{{ $answer->id }}" value="{{ $answer->id }} " />
        @endif
        <label for="answer{{ $answer->id }}">{{ $answer->text }}</label>
      </div>
      @endforeach
      <button type="submit" class="btn btn-primary">Submit and mark content as completed</button>
    </form>
  </div>
</div>

@endsection