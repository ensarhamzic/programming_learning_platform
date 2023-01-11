@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
@endsection

@section('content')

<h1 class='admin_h1'>Notifications</h1>
<div class="notificationActions">
  <a class="btn btn-success" href="{{ route('admin.notifications.create') }}">Create notification</a>
</div>


<div class="notificationsList">
  @if (count($notifications) == 0)
  <p class='admin_p'>There are no notifications</p>
  @else
  @foreach ($notifications as $notification)
  <div class="oneNotification">
    <div>
      <h2 class='admin_h2'>{{ $notification->title }}</h2>
      <p class='admin_p'>{{ $notification->message }}</p>
    </div>
    <form method="POST" class="flexForm usersDelForm"
      action="{{ route('admin.notifications.destroy', [$notification->id]) }}">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger manageDelBtn">Delete</button>
    </form>

  </div>
  @endforeach
  @endif
</div>
@endsection