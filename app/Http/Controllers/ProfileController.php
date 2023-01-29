<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Models\User;
use Illuminate\Validation\Rule;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::check())
            return redirect()->route('login');

        $user = Auth::user();

        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($jmbg)
    {
        $stringId = (string)$jmbg;
        while (strlen($stringId) < 13) {
            $stringId = '0' . $stringId;
        }
        $user = User::findOrfail($stringId);
        if (!$user->approved) abort(404);

        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        if (!Auth::check())
            return redirect()->route('login');

        if (!Auth::user()->approved) abort(404);

        return view('profile.edit');
    }

    public function settings()
    {
        if (!Auth::check())
            return redirect()->route('login');

        if (!Auth::user()->approved) abort(404);

        return view('profile.settings');
    }

    public function changePassword(Request $request)
    {
        if (!Auth::check())
            return redirect()->route('login');

        if (!Auth::user()->approved) abort(404);

        $request->validate([
            'currentPassword' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if (!Auth::user()->checkPassword($request->currentPassword)) {
            return redirect()->back()->withErrors(['currentPassword' => 'Wrong password']);
        }

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.settings')->with('success', 'Password changed successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!Auth::user()->approved) abort(404);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:1',  Rule::in(['M', 'F'])],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_country' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
        ]);

        if ($request->email != Auth::user()->email) {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }

        if ($request->fullNum && $request->fullNum != Auth::user()->mobile_number) {
            $request->validate([
                'fullNum' => ['required', 'string', 'max:255', 'validPhone', 'unique:users,mobile_number'],
            ]);
        }

        $image_uploaded = null;
        if ($request->imageURI && !$request->deletePicture) {
            // dd("A");
            $image_uploaded = Cloudinary::upload($request->imageURI)->getSecurePath();
        }

        if ($request->deletePicture) {
            // dd("B");
            $image_uploaded = "";
        }


        $username = strtolower($request->name . $request->surname);
        $similarUsernames = User::where('username', 'like', $username . '%')->where('username', "!=", Auth::user()->username)->get();
        if (count($similarUsernames) > 0) {
            $username = $username . (count($similarUsernames) + 1);
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->username = $username;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->mobile_number = $request->fullNum ? $request->fullNum : $user->mobile_number;
        $user->birth_place = $request->birth_place;
        $user->birth_country = $request->birth_country;
        $user->birth_date = $request->birth_date;
        if ($image_uploaded == "") {
            $user->profile_picture = $image_uploaded;
        } else
            $user->profile_picture = $image_uploaded ? $image_uploaded : $user->profile_picture;
        $user->save();

        return redirect()->route('profile.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = Auth::user();

        $user->delete();

        return redirect()->route('login');
    }

    public function showTeachingCourses($jmbg)
    {
        $stringId = (string)$jmbg;
        while (strlen($stringId) < 13) {
            $stringId = '0' . $stringId;
        }
        $user = User::findOrfail($stringId);

        if (!$user->isTeacher()) {
            abort(404);
        }

        $courses = $user->courses->where('active', 1);
        $type = 'teaching';
        return view('profile.courses', compact('user', 'courses', 'type'));
    }

    public function showAttendingCourses($jmbg)
    {
        $stringId = (string)$jmbg;
        while (strlen($stringId) < 13) {
            $stringId = '0' . $stringId;
        }
        $user = User::findOrfail($stringId);

        if (!$user->isStudent()) {
            abort(404);
        }

        $attends = $user->attends;
        $courses = [];
        foreach ($attends as $attend) {
            $courses[] = $attend->course;
        }
        $courses = collect($courses);

        $type = 'attending';

        return view('profile.courses', compact('user', 'courses', 'type'));
    }
}
