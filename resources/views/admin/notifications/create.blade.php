@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
@endsection

@section('content')
<form method="POST" action="{{ route('admin.notifications.store') }}" class="notificationForm">
  @csrf
  <h3>Add new notification</h3>

  <div class="row mb-3">
    <label for="title" class="col-md-3 col-form-label">Title</label>

    <div class="col-md-9">
      <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title"
        value="{{ old('title') }}" autocomplete="title" autofocus>

      @error('title')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>

  <div class="row mb-3">
    <label for="message" class="col-md-3 col-form-label">Message</label>

    <div class="col-md-9">
      <textarea id="message" type="text" class="form-control @error('message') is-invalid @enderror" name="message"
        rows="5" value="{{ old('message') }}" autocomplete="message" autofocus></textarea>

      @error('message')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>

  <div class="notificationActions">
    <button type="submit" class="btn btn-success">Create</button>
    <a class="btn btn-danger" href="{{ route('admin.notifications.index') }}">Cancel</a>
  </div>
</form>
@endsection