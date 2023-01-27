@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/notification.css') }}" />
@endsection

@section('content')
<div class="card notification">
  <div class="card-header">
    {{ $notification->title }}
  </div>
  <div class="card-body">
    <h5 class="card-title">{{ $notification->title }}</h5>
    <p class="card-text">{{ $notification->message }}</p>
    <a href="{{ route('index') }}" class="btn btn-primary customBtn">Home</a>
  </div>
</div>
@endsection