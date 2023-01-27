@extends('layouts.app')


@section('options')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/auth.css') }}" />

@endsection

@section('content')
<div style="display:none;" id="cropModal">
  <div class="overlay"></div>
  <div class="card cropModal">
    <div class="card-header">Crop banner image</div>
    <div class="card-body cropDiv">
      <img id="image" class="image">
    </div>
    <div class="card-footer d-flex justify-content-center align-items-center">
      <button class="btn btn-success cropBtn customBtn" id="cropBtn">Crop image</button>
    </div>
  </div>
</div>


<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Edit profile</div>

        <div class="card-body">
          <form id="regForm" method="POST" action="{{ route('profile.update') }}" novalidate>
            @csrf
            @method('PUT')
            <div class="row mb-3">
              <label for="JMBG" class="col-md-4 col-form-label text-md-end">JMBG</label>

              <div class="col-md-6">
                <input id="JMBG" type="text" class="form-control @error('JMBG') is-invalid @enderror"
                  value="{{ Auth::user()->JMBG }}" autocomplete="JMBG" autofocus disabled>

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

              @if (Auth::user()->gender == "M")
              <div class="col-md-3 d-flex justify-center align-items-center">
                <input id="maleGender" type="radio" value="M" name="gender" checked />
                <label for="maleGender">&nbsp;&nbsp;&nbsp;Male</label>
              </div>
              <div class="col-md-3 d-flex justify-center align-items-center">
                <input id="femaleGender" type="radio" value="F" name="gender" />
                <label for="femaleGender">&nbsp;&nbsp;&nbsp;Female</label>
              </div>
              @else
              <div class="col-md-3 d-flex justify-center align-items-center">
                <input id="maleGender" type="radio" value="M" name="gender" />
                <label for="maleGender">&nbsp;&nbsp;&nbsp;Male</label>
              </div>
              <div class="col-md-3 d-flex justify-center align-items-center">
                <input id="femaleGender" type="radio" value="F" name="gender" checked />
                <label for="femaleGender">&nbsp;&nbsp;&nbsp;Female</label>
              </div>
              @endif

              @error('gender')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>


            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                  value="{{ Auth::user()->name }}" autocomplete="name" autofocus>

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
                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror"
                  name="surname" value="{{  Auth::user()->surname }}" autocomplete="surname" autofocus>

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
                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                  value="{{ Auth::user()->email }}" autocomplete="email">

                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <span class="invalid-feedback" role="alert" id="emailError"></span>
              </div>
            </div>

            <div class="row mb-3">
              <label for="description" class="col-md-4 col-form-label text-md-end">Profile picture</label>

              <div class="col-md-6">
                <input id="profilePicture" type="file"
                  class="form-control @error('profilePicture') is-invalid @enderror" name="profilePicture" required
                  rows="10" autocomplete="current-profilePicture" accept="image/png, image/jpeg, image/jpg" />

                @error('imageURI')
                <span class="invalid-feedback" role="alert" id="imageServerError">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

                <span class="invalid-feedback" role="alert" id="profilePictureError"></span>
                <small class="d-block text-center"><i>Leave empty not to change</i></small>
              </div>
            </div>
            <input type="hidden" name="imageURI" value="" id="imageURI" />


            <input type="hidden" id="fullNum" name="fullNum" value="{{ Auth::user()->mobile_number }}">

            <div class="row mb-3">
              <label for="mobile_number" class="col-md-4 col-form-label text-md-end">Mobile Number</label>

              <div class="col-md-6">
                <input id="mobile_number" type="tel" class="form-control @error('fullNum') is-invalid @enderror"
                  name="mobile_number" value="" autocomplete="mobile_number" autofocus>

                @error('fullNum')
                <span class="invalid-feedback" id="mobileNumberServerError" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <small class="d-block text-center"><i>Leave empty not to change</i></small>
                <span class="invalid-feedback" role="alert" id="mobileNumberError"></span>
              </div>
            </div>

            <div class="row mb-3">
              <label for="birth_place" class="col-md-4 col-form-label text-md-end">Birth Place</label>

              <div class="col-md-6">
                <input id="birth_place" type="text" class="form-control @error('birth_place') is-invalid @enderror"
                  name="birth_place" value="{{ Auth::user()->birth_place }}" autocomplete="birth_place" autofocus>

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
                <input id="birth_country" type="text" class="form-control @error('birth_country') is-invalid @enderror"
                  name="birth_country" value="{{ Auth::user()->birth_country }}" autocomplete="birth_country" s
                  autofocus>

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
                <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror"
                  name="birth_date" value="{{ Auth::user()->birth_date }}" s autocomplete="birth_date" autofocus>

                @error('birth_date')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <span class="invalid-feedback" role="alert" id="birthDateError"></span>
              </div>
            </div>

            <div class="row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary customBtn">
                  Update profile
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

        const name = document.getElementById("name");
        const nameError = document.getElementById("nameError");

        const email = document.getElementById("email");
        const emailError = document.getElementById("emailError");

        const surname = document.getElementById("surname");
        const surnameError = document.getElementById("surnameError");

        const birthPlace = document.getElementById("birth_place");
        const birthPlaceError = document.getElementById("birthPlaceError");

        const birthCountry = document.getElementById("birth_country");
        const birthCountryError = document.getElementById("birthCountryError");

        const birthDate = document.getElementById("birth_date");
        const birthDateError = document.getElementById("birthDateError");

        const mobileNumber = document.getElementById("mobile_number");
        const mobileNumberError = document.getElementById("mobileNumberError");

        const profilePicture = document.getElementById("profilePicture");
        const profilePictureError = document.getElementById("profilePictureError");

        // reset all errors
        nameError.innerHTML = "";
        emailError.innerHTML = "";
        surnameError.innerHTML = "";
        birthPlaceError.innerHTML = "";
        birthCountryError.innerHTML = "";
        birthDateError.innerHTML = "";
        mobileNumberError.innerHTML = "";
        profilePictureError.innerHTML = "";

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
        if(mobileNumber.value.trim().length > 0) {
          if(!phoneInput.isValidNumber()) {
            mobileNumberError.innerHTML = "Mobile number should be valid";
            mobileNumberError.style.display = "block";
            formValid = false;
          } else {
            mobileNumberError.innerHTML = "";
          }
        }

        //email should be valid
        if(!email.value.match(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/)) {
            emailError.innerHTML = "Email should be valid";
            emailError.style.display = "block";
            formValid = false;
        } else {
            emailError.innerHTML = "";
        }

        if (profilePicture.files.length > 0) {
            if (!profilePicture.files[0].type.match(/^image\//)) {
                profilePictureError.innerHTML = "Profile picture must be an image";
                profilePictureError.style.display = "block";
                formValid = false;
            } else {
                profilePictureError.innerHTML = "";
            }
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
        let mobileError = document.getElementById('mobileNumberServerError')
        if(mobileError) {
            mobileError.style.display = "block";
        }
    }


    let profilePicture = document.getElementById('profilePicture');
  let newProfilePicture = profilePicture.cloneNode(true);
  profilePicture.parentNode.replaceChild(newProfilePicture, profilePicture);
  newProfilePicture.addEventListener('change', function () {
    if (this.files && this.files[0] && this.files[0].type.match(/^image\//)) {
      document.getElementById('cropModal').style.display = 'block';
      let image =  document.getElementById('image')
      image.src = URL.createObjectURL(this.files[0])
      const cropper = new Cropper(image, { aspectRatio: 1 / 1});
      let cropBtn = document.getElementById('cropBtn');
      let newCropBtn = cropBtn.cloneNode(true);
      cropBtn.parentNode.replaceChild(newCropBtn, cropBtn);
      newCropBtn.addEventListener('click', () => {
        let imageURI = cropper.getCroppedCanvas().toDataURL("image/png");
        document.getElementById('imageURI').value = imageURI;
        document.getElementById('cropModal').style.display = 'none';
      });
    }
  });

    
</script>

@endsection