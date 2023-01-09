@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="JMBG" class="col-md-4 col-form-label text-md-end">JMBG</label>

                            <div class="col-md-6">
                                <input id="JMBG" type="text" class="form-control @error('JMBG') is-invalid @enderror"
                                    name="JMBG" value="{{ old('JMBG') }}" required autocomplete="JMBG" autofocus>

                                @error('JMBG')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Gender</label>

                            <div class="col-md-3 d-flex justify-center align-items-center">
                                <input id="maleGender" type="radio" value="M" name="gender" checked />
                                <label for="maleGender">&nbsp;&nbsp;&nbsp;Male</label>
                            </div>
                            <div class="col-md-3 d-flex justify-center align-items-center">
                                <input id="femaleGender" type="radio" value="F" name="gender" />
                                <label for="femaleGender">&nbsp;&nbsp;&nbsp;Female</label>
                            </div>

                            @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">I register as</label>

                            <div class="col-md-3 d-flex justify-center align-items-center">
                                <input id="student" type="radio" value="student" name="role" checked />
                                <label for="student">&nbsp;&nbsp;&nbsp;Student</label>
                            </div>
                            <div class="col-md-3 d-flex justify-center align-items-center">
                                <input id="teacher" type="radio" value="teacher" name="role" />
                                <label for="teacher">&nbsp;&nbsp;&nbsp;Teacher</label>
                            </div>

                            @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="surname" class="col-md-4 col-form-label text-md-end">Surname</label>

                            <div class="col-md-6">
                                <input id="surname" type="text"
                                    class="form-control @error('surname') is-invalid @enderror" name="surname"
                                    value="{{ old('surname') }}" required autocomplete="surname" autofocus>

                                @error('surname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address')
                                }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="birth_place" class="col-md-4 col-form-label text-md-end">Birth Place</label>

                            <div class="col-md-6">
                                <input id="birth_place" type="text"
                                    class="form-control @error('birth_place') is-invalid @enderror" name="birth_place"
                                    value="{{ old('birth_place') }}" required autocomplete="birth_place" autofocus>

                                @error('birth_place')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="birth_country" class="col-md-4 col-form-label text-md-end">Birth Country</label>

                            <div class="col-md-6">
                                <input id="birth_country" type="text"
                                    class="form-control @error('birth_country') is-invalid @enderror"
                                    name="birth_country" value="{{ old('birth_country') }}" required
                                    autocomplete="birth_country" autofocus>

                                @error('birth_country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="birth_date" class="col-md-4 col-form-label text-md-end">Birth Date</label>

                            <div class="col-md-6">
                                <input id="birth_date" type="date"
                                    class="form-control @error('birth_date') is-invalid @enderror" name="birth_date"
                                    value="{{ old('birth_date') }}" required autocomplete="birth_date" autofocus>

                                @error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="mobile_number" class="col-md-4 col-form-label text-md-end">Mobile Number</label>

                            <div class="col-md-6">
                                <input id="mobile_number" type="text"
                                    class="form-control @error('mobile_number') is-invalid @enderror"
                                    name="mobile_number" value="{{ old('mobile_number') }}" required
                                    autocomplete="mobile_number" autofocus>

                                @error('mobile_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password')
                                }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm
                                Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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