@extends('layouts.app')


@section('options')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form id="regForm" method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        <div class="row mb-3">
                            <label for="JMBG" class="col-md-4 col-form-label text-md-end">JMBG</label>

                            <div class="col-md-6">
                                <input id="JMBG" type="text" class="form-control @error('JMBG') is-invalid @enderror"
                                    name="JMBG" value="{{ old('JMBG') }}" autocomplete="JMBG" autofocus>

                                @error('JMBG')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" id="jmbgError"></span>
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
                                    name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" id="nameError"></span>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <label for="surname" class="col-md-4 col-form-label text-md-end">Surname</label>

                            <div class="col-md-6">
                                <input id="surname" type="text"
                                    class="form-control @error('surname') is-invalid @enderror" name="surname"
                                    value="{{ old('surname') }}" autocomplete="surname" autofocus>

                                @error('surname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" id="surnameError"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address')
                                }}</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" id="emailError"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="birth_place" class="col-md-4 col-form-label text-md-end">Birth Place</label>

                            <div class="col-md-6">
                                <input id="birth_place" type="text"
                                    class="form-control @error('birth_place') is-invalid @enderror" name="birth_place"
                                    value="{{ old('birth_place') }}" autocomplete="birth_place" autofocus>

                                @error('birth_place')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" id="birthPlaceError"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="birth_country" class="col-md-4 col-form-label text-md-end">Birth Country</label>

                            <div class="col-md-6">
                                <input id="birth_country" type="text"
                                    class="form-control @error('birth_country') is-invalid @enderror"
                                    name="birth_country" value="{{ old('birth_country') }}" autocomplete="birth_country"
                                    s autofocus>

                                @error('birth_country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" id="birthCountryError"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="birth_date" class="col-md-4 col-form-label text-md-end">Birth Date</label>

                            <div class="col-md-6">
                                <input id="birth_date" type="date"
                                    class="form-control @error('birth_date') is-invalid @enderror" name="birth_date"
                                    value="{{ old('birth_date') }}" s autocomplete="birth_date" autofocus>

                                @error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" id="birthDateError"></span>
                            </div>
                        </div>

                        <input type="hidden" id="fullNum" name="fullNum" value="">

                        <div class="row mb-3">
                            <label for="mobile_number" class="col-md-4 col-form-label text-md-end">Mobile Number</label>

                            <div class="col-md-6">
                                <input id="mobile_number" type="tel"
                                    class="form-control @error('fullNum') is-invalid @enderror" name="mobile_number"
                                    value="" autocomplete="mobile_number" autofocus>

                                @error('fullNum')
                                <span class="invalid-feedback" id="mobileNumberServerError" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" id="mobileNumberError"></span>
                            </div>


                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password')
                                }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" s
                                    autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <span class="invalid-feedback" role="alert" id="passwordError"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm
                                Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" autocomplete="new-password">
                                <span class="invalid-feedback" role="alert" id="confirmPaswordError"></span>
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

@section('scripts')
<script>
    let phoneInput;
    document.getElementById("regForm").onsubmit = function (e) {
        e.preventDefault();
        let formValid = true;
        const jmbg = document.getElementById("JMBG");
        const jmbgError = document.getElementById("jmbgError");

        const name = document.getElementById("name");
        const nameError = document.getElementById("nameError");

        const surname = document.getElementById("surname");
        const surnameError = document.getElementById("surnameError");

        const birthPlace = document.getElementById("birth_place");
        const birthPlaceError = document.getElementById("birthPlaceError");

        const birthCountry = document.getElementById("birth_country");
        const birthCountryError = document.getElementById("birthCountryError");

        const birthDate = document.getElementById("birth_date");
        const birthDateError = document.getElementById("birthDateError");

        const mobileNumberError = document.getElementById("mobileNumberError");

        const password = document.getElementById("password");
        const passwordError = document.getElementById("passwordError");

        const confirmPassword = document.getElementById("password-confirm");
        const confirmPasswordError = document.getElementById("confirmPaswordError");

        // jmbg should be 13 characters and no letters
        if (jmbg.value.length != 13 || isNaN(jmbg.value)) {
            console.log('a')
            jmbgError.innerHTML = "JMBG should be 13 characters and no letters";
            jmbgError.style.display = "block";
            formValid = false;
        } else {
            jmbgError.innerHTML = "";
        }

        // name should be at least 3 characters
        if (name.value.length < 3) {
            nameError.innerHTML = "Name should be at least 3 characters";
            nameError.style.display = "block";
            formValid = false;
        } else {
            nameError.innerHTML = "";
        }

        // surname should be at least 3 characters
        if (surname.value.length < 3) {
            surnameError.innerHTML = "Surname should be at least 3 characters";
            surnameError.style.display = "block";
            formValid = false;
        } else {
            surnameError.innerHTML = "";
        }

        // birth place should be at least 3 characters
        if (birthPlace.value.length < 3) {
            birthPlaceError.innerHTML = "Birth place should be at least 3 characters";
            birthPlaceError.style.display = "block";
            formValid = false;
        } else {
            birthPlaceError.innerHTML = "";
        }

        // birth country should be at least 3 characters
        if (birthCountry.value.length < 3) {
            birthCountryError.innerHTML = "Birth country should be at least 3 characters";
            birthCountryError.style.display = "block";
            formValid = false;
        } else {
            birthCountryError.innerHTML = "";
        }

        // birth date is required
        if (birthDate.value == "") {
            birthDateError.innerHTML = "Birth date is required";
            birthDateError.style.display = "block";
            formValid = false;
        } else {
            birthDateError.innerHTML = "";
        }

        // mobile number should be valid
        if(!phoneInput.isValidNumber()) {
            mobileNumberError.innerHTML = "Mobile number should be valid";
            mobileNumberError.style.display = "block";
            formValid = false;
        } else {
            mobileNumberError.innerHTML = "";
        }

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

        //email should be valid
        if(!email.value.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)) {
            emailError.innerHTML = "Email should be valid";
            emailError.style.display = "block";
            formValid = false;
        } else {
            emailError.innerHTML = "";
        }

        if(formValid) {
            this.submit();
        }
         
    }

    function getIp(callback) {
 fetch('https://ipinfo.io/json?token=0d18d37ce41d1d', { headers: { 'Accept': 'application/json' }})
   .then((resp) => resp.json())
   .catch(() => {
     return {
       country: 'us',
     };
   })
   .then((resp) => callback(resp.country));
}

    window.onload = function () {
        const phoneInputField = document.querySelector("#mobile_number");
        phoneInput = window.intlTelInput(phoneInputField,
        {
            initialCountry: "auto",
            geoIpLookup: getIp,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
        phoneInputField.onblur = function () {
            console.log(phoneInput.getNumber())
            document.getElementById("fullNum").value = phoneInput.getNumber();
        };

        const a = document.getElementById("mobileNumberServerError");
        a.style.display = "block";
    }

    
</script>

@endsection