<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Models\User;

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

        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

        $courses = $user->courses;
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
