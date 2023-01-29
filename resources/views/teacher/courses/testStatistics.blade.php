@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/teacher.css') }}" />
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header ">
          <h3>Course attendants</h3>
          <button type="button" class="backButton" onclick="history.back()">
            &lt;&lt; Go Back </button>
        </div>
        <div class="card-body">
          <table class="table attendantsTable">
            <thead>
              <tr>
                <th>Question</th>
                <th>Score</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($questions as $question)
              <tr>
                <td>
                  {{ $question->text }}
                </td>

                <td>
                  <span>{{ $question->usersWithCorrectAnswer }}</span> / {{
                  $usersDoneTest }}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="totalPoints">
    Average points: <span>{{ number_format( $averagePoints, 2, '.', '' ) }}</span> / {{
    count(collect($course->questions())->where('level', 'easy')) }}
  </div>

</div>

@endsection