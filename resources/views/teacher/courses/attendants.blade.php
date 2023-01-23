@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/teacher.css') }}" />
@endsection

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3>Course attendants</h3>
        </div>
        <div class="card-body">
          <table class="table table-striped attendantsTable">
            <thead>
              <tr>
                <th>Name</th>
                <th>Surname</th>
                <th>Test type</th>
                <th>Test points</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($attendants as $attendant)
              <tr>
                <td>{{ $attendant->user->name }}</td>
                <td>{{ $attendant->user->surname }}</td>

                @if (!$attendant->user->doneTest($course))
                <td>/</td>
                <td>/</td>
                @else
                <td>{{ $attendant->user->testLevel($course) }}</td>
                <td>
                  <a href="{{ route('teacher.courses.userTestResults', [$course->id, $attendant->user->JMBG]) }}">
                    {{ $attendant->user->testPoints($course) }}
                  </a>
                </td>
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection