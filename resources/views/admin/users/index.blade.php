@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}" />

<script>
  const deleteClickHandler = (JMBG) => {
    var url = '{{ route("admin.users.destroy", ":JMBG") }}';
    url = url.replace(':JMBG', JMBG);
    document.getElementById("deleteForm").setAttribute("action", url);
  }
</script>
@endsection

@section('content')
<x-delete-modal title="Delete user" content="Are you sure you want to delete this user?" buttonContent="Delete user" />

@if (session('success'))
<div class="alert alert-info myAlert" role="alert">
  {{ session('success') }}
</div>
@endif

<h1 class='admin_h1'>Manage users</h1>
<form class="flexForm">
  <label for="searchInput">Search</label>
  <input type="text" class="form-control" id="searchInput" placeholder="Name, surname, username or email" name="search"
    value="{{ request()->get('search') }}">
  <button type="submit" class="btn btn-primary customBtn">Search</button>
</form>
<div class="usersList">
  @if (count($users) == 0)
  <p class='admin_p'>There are no approved users</p>
  @else
  @foreach ($users as $user)
  <div class="oneUser">
    <div>
      <div class="userImage">
        <img src="{{ $user->getProfilePicture() }}" alt="user image" class="userImage">
      </div>
      <h2 class='admin_h2'>{{ $user->name }} {{ $user->surname }}</h2>
      <p class='admin_p'>JMBG: {{ $user->JMBG }}</p>
      <p class='admin_p'>username: {{ $user->username }}</p>
      <p class='admin_p'>email: {{ $user->email }}</p>
      <p class='admin_p'>Created at: {{ $user->created_at }}</p>
      <p class='admin_p'>Mobile number: {{ $user->mobile_number }}</p>
      <p class='admin_p'>Role: {{ $user->role->name }}</p>
    </div>
    <div class="delDiv">
      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
        onclick="deleteClickHandler({{ $user->JMBG }})">Delete User</button>
    </div>

  </div>
  @endforeach
  @endif
</div>
@endsection