<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\AuthenticationException;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'JMBG' => ['required', 'string', 'min:13', 'max:13', 'unique:users'],
            'role' => ['required', 'string', 'max:255', Rule::in(['teacher', 'student'])],
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:1',  Rule::in(['M', 'F'])],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_country' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'fullNum' => ['required', 'string', 'max:255', 'validPhone', 'unique:users,mobile_number'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $roleId = Role::where('name', "=", $data['role'])->where('name', '!=', 'admin')->first()->id;
        $name = strtolower($data['name']);
        $surname = strtolower($data['surname']);
        $username = $name . $surname;

        $similarUsernames = User::where('username', 'like', $username . '%')->get();
        if (count($similarUsernames) > 0) {
            $username = $username . (count($similarUsernames) + 1);
        }


        $image_uploaded = null;
        if ($data['imageURI']) {
            $image_uploaded = Cloudinary::upload($data['imageURI'])->getSecurePath();
        }


        Session::flash('success', 'You have successfully registered! Now, you must wait for the Admin to approve your registration request');
        $user = new User();
        $user->JMBG = $data['JMBG'];
        $user->role_id = $roleId;
        $user->name = $data['name'];
        $user->surname = $data['surname'];
        $user->gender = $data['gender'];
        $user->birth_place = $data['birth_place'];
        $user->birth_country = $data['birth_country'];
        $user->birth_date = $data['birth_date'];
        $user->mobile_number = $data['fullNum'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->approved = $roleId == 3 ? true : false;
        $user->profile_picture = $image_uploaded ? $image_uploaded : "";
        $user->username = $username;
        $user->save();

        $lastUser = User::latest()->first();

        if ($lastUser->role_id == 2) {
            event(new Registered($lastUser));
            throw new AuthenticationException();
        }

        return $lastUser;
    }
}
