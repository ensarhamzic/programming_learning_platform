@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}" />

<script>
  const deleteClickHandler = (id) => {
    var url = '{{ route("admin.notifications.destroy", ":id") }}';
    url = url.replace(':id', id);
    document.getElementById("deleteForm").setAttribute("action", url);
  }
</script>
@endsection

@section('content')
<x-delete-modal title="Delete notification" content="Are you sure you want to delete this notification?"
  buttonContent="Delete notification" />

<h1 class='admin_h1'>Notifications</h1>
<div class="notificationActions">
  <a class="btn btn-success customBtn" href="{{ route('admin.notifications.create') }}">Create notification</a>
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

    <button type="button" class="btn btn-danger manageDelBtn" data-bs-toggle="modal" data-bs-target="#deleteModal"
      onclick="deleteClickHandler({{ $notification->id }})">Delete Notification</button>
  </div>
  @endforeach
  @endif
</div>
@endsection