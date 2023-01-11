@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
@endsection

@section('content')
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
  <button type="submit" class="btn btn-primary">Search</button>
</form>
<div class="usersList">
  @if (count($users) == 0)
  <p class='admin_p'>There are no users</p>
  @else
  @foreach ($users as $user)
  <div class="oneUser">
    <h2 class='admin_h2'>{{ $user->name }} {{ $user->surname }}</h2>
    <p class='admin_p'>JMBG: {{ $user->JMBG }}</p>
    <p class='admin_p'>username: {{ $user->username }}</p>
    <p class='admin_p'>email: {{ $user->email }}</p>
    <p class='admin_p'>Created at: {{ $user->created_at }}</p>
    <p class='admin_p'>Mobile number: {{ $user->mobile_number }}</p>
    <p class='admin_p'>Role: {{ $user->role->name }}</p>
    <form method="POST" action="{{ route('admin.users.destroy', [$user->JMBG]) }}" class="flexForm usersDelForm">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger manageDelBtn">Delete</button>
    </form>

  </div>
  @endforeach
  @endif
</div>
@endsection