@extends('layouts.app')

@section('options')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}" />

<script>
  const deleteClickHandler = (JMBG) => {
    var url = '{{ route("admin.registrations.destroy", ":JMBG") }}';
    url = url.replace(':JMBG', JMBG);
    document.getElementById("deleteForm").setAttribute("action", url);
  }
</script>
@endsection

@section('content')
<x-delete-modal title="Delete user" content="Are you sure you want to delete this user?" buttonContent="Delete user" />
<div>
  @if (session('approved'))
  <div class="alert alert-info myAlert" role="alert">
    {{ session('approved') }}
  </div>
  @endif
  @if (session('rejected'))
  <div class="alert alert-danger myAlert" role="alert">
    {{ session('rejected') }}
  </div>
  @endif
  <h1 class='admin_h1'>Approve or reject registrations</h1>
  <div class="usersList">
    @if (count($users) == 0)
    <p class='admin_p'>There are no registration requests</p>
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
      <div class='formDiv'>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
          onclick="deleteClickHandler({{ $user->JMBG }})">Reject</button>
        <form method="POST" action="{{ route('admin.registrations.update', [$user->JMBG]) }}">
          @csrf
          @method("PATCH")
          <button type="submit" class="btn btn-info">Approve</button>
        </form>
      </div>
    </div>
    @endforeach
    @endif
  </div>
</div>
@endsection