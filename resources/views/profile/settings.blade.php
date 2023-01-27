@extends('layouts.app')


@section('options')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />

<script>
  const deleteClickHandler = () => {
    var url = '{{ route("profile.destroy") }}';
    document.getElementById("deleteForm").setAttribute("action", url);
  }
</script>

@endsection

@section('content')
<x-delete-modal title="Delete account"
  content="Are you sure you want to delete this account? This action cannot be undone"
  buttonContent="Delete my profile" />
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      @if (Session::has('success'))
      <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
      </div>
      @endif
      <div class="card">
        <div class="card-header">Profile Settings</div>

        <div class="card-body">
          <form id="regForm" method="POST" action="{{ route('profile.changePassword') }}" novalidate>
            @csrf
            @method('PUT')

            <div class="row mb-3">
              <label for="currentPassword" class="col-md-4 col-form-label text-md-end">Current Password
              </label>

              <div class="col-md-6">
                <input id="currentPassword" type="password"
                  class="form-control @error('currentPassword') is-invalid @enderror" name="currentPassword"
                  autocomplete="new-currentPassword">

                @error('currentPassword')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <span class="invalid-feedback" role="alert" id="currentPasswordError"></span>
              </div>
            </div>
            <div class="row mb-3">
              <label for="password" class="col-md-4 col-form-label text-md-end">New Password</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                  name="password" s autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <span class="invalid-feedback" role="alert" id="passwordError"></span>
              </div>
            </div>

            <div class="row mb-3">
              <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm New Password</label>

              <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                  autocomplete="new-password">
                <span class="invalid-feedback" role="alert" id="confirmPaswordError"></span>
              </div>


            </div>

            <div class="row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary customBtn">
                  Change Password
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal"
                  onclick="deleteClickHandler()">
                  Delete Account
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  let phoneInput;
    document.getElementById("regForm").onsubmit = function (e) {
        e.preventDefault();
        let formValid = true;

        const currentPassword = document.getElementById("currentPassword");

        const newPassword = document.getElementById("password");
        const newPasswordError = document.getElementById("passwordError");

        const confirmPassword = document.getElementById("password-confirm");
        const confirmPasswordError = document.getElementById("confirmPaswordError");


        // password should be at least 8 characters
        if (password.value.length < 8) {
            passwordError.innerHTML = "Password should be at least 8 characters";
            passwordError.style.display = "block";
            formValid = false;
        } else {
            passwordError.innerHTML = "";
        }

        // confirm password should be the same as password
        if (confirmPassword.value != password.value) {
            confirmPasswordError.innerHTML = "Confirm password should be the same as password";
            confirmPasswordError.style.display = "block";
            formValid = false;
        } else {
            confirmPasswordError.innerHTML = "";
        }


        if(formValid) {
            this.submit();
        }
         
    }
    
</script>

@endsection