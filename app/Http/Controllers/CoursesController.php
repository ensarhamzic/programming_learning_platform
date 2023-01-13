<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Course;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeCourses = Course::where("user_JMBG", auth()->user()->JMBG)->where('active', 1)->get();
        $inactiveCourses = Course::where("user_JMBG", auth()->user()->JMBG)->where('active', 0)->get();
        return view('teacher.courses.index', compact('activeCourses', 'inactiveCourses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teacher.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5',
            'description' => 'required|min:30',
            'imageURI' => 'required',
        ]);

        $imageURI = $request->imageURI;
        $image_uploaded = Cloudinary::upload($imageURI)->getSecurePath();

        $course = new Course();
        $course->user_JMBG = auth()->user()->JMBG;
        $course->title = $request->title;
        $course->description = $request->description;
        $course->image = $image_uploaded;
        $course->active = 1;
        $course->save();

        return redirect()->route('teacher.courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('teacher.courses.show', compact('course'));
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
        $course = Course::find($id);
        $course->delete();
        return redirect()->route('teacher.courses.index');
    }

    public function toggleActive($id)
    {
        $course = Course::find($id);
        $course->active = !$course->active;
        $course->save();
        return redirect()->route('teacher.courses.index');
    }
}
