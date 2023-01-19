<?php

namespace App\Http\Controllers;

use App\Models\ContentType;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;
use Auth;


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
        $course = Course::findOrFail($id);
        if (Auth::user()->ownsCourse($course))
            return view('teacher.courses.edit', compact('course'));
        return redirect()->back();
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
        if (!Auth::user()->ownsCourse(Course::find($id)))
            return redirect()->back();

        $request->validate([
            'title' => 'required|min:5',
            'description' => 'required|min:30',
        ]);

        $course = Course::find($id);
        $course->title = $request->title;
        $course->description = $request->description;
        if ($request->imageURI) {
            $imageURI = $request->imageURI;
            $image_uploaded = Cloudinary::upload($imageURI)->getSecurePath();
            $course->image = $image_uploaded;
        }
        $course->save();

        return redirect()->route('courses.show', $id)->with('success', 'Course updated successfully');
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

    public function addSection(Request $request, $courseId)
    {
        return view('teacher.courses.addSection', compact('courseId'));
    }

    public function storeSection(Request $request, $courseId)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $course = Course::find($courseId);
        if (!Auth::user()->ownsCourse($course))
            return redirect()->back();

        $course->sections()->create([
            'title' => $request->title,
        ]);

        return redirect()->route('courses.show', $courseId)->with('success', 'Section added successfully');
    }

    public function addContent(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        if (!Auth::user()->ownsCourse($course))
            return redirect()->back();

        return view('teacher.courses.addContent', ['course' => $course]);
    }

    public function storeContent(Request $request,  $courseId)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'section' => 'required',
        ]);

        $uploadedFileUrl = Cloudinary::upload($request->file('content')->getRealPath())->getSecurePath();

        $course = Course::find($courseId);
        $contentType = ContentType::where('name', $request->contentType)->first();

        if (!Auth::user()->ownsCourse($course))
            return redirect()->back();


        $course->sections()->find($request->section)->contents()->create([
            'title' => $request->title,
            'source' => $uploadedFileUrl,
            'content_type_id' => $contentType->id,
        ]);

        return redirect()->route('courses.show', $courseId)->with('success', 'Content added successfully');
    }
}
