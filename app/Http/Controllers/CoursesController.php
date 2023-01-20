<?php

namespace App\Http\Controllers;

use App\Models\ContentType;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Auth;


use App\Models\Course;
use App\Models\Question;
use App\Models\Section;
use App\Models\Content;

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
        $stringJMBG = (string)auth()->user()->JMBG;
        while (strlen($stringJMBG) < 13) {
            $stringJMBG = '0' . $stringJMBG;
        }
        $course->user_JMBG = $stringJMBG;
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

    public function editSection(Request $request, $courseId, $sectionId)
    {
        $course = Course::findOrFail($courseId);
        $section = $course->sections()->findOrFail($sectionId);

        if (!Auth::user()->ownsCourse($course))
            return redirect()->back();

        return view('teacher.courses.editSection', ['course' => $course, 'section' => $section]);
    }

    public function updateSection(Request $request, $courseId, $sectionId)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $course = Course::findOrFail($courseId);
        $section = $course->sections()->findOrFail($sectionId);

        if (!Auth::user()->ownsCourse($course))
            return redirect()->back();

        $section->title = $request->title;
        $section->save();

        return redirect()->route('courses.show', $courseId)->with('success', 'Section updated successfully');
    }

    public function deleteSection(Request $request, $courseId, $sectionId)
    {
        $course = Course::findOrFail($courseId);
        $section = $course->sections()->findOrFail($sectionId);

        if (!Auth::user()->ownsCourse($course))
            return redirect()->back();

        $section->delete();

        return redirect()->route('courses.show', $courseId)->with('success', 'Section deleted successfully');
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
            'section' => 'required',
            'checkQuestion' => "required",
            'checkQuestionAnswers' => "required",
            'easyQuestion' => "required",
            'easyQuestionAnswers' => "required",
            'mediumQuestion' => "required",
            'mediumQuestionAnswers' => "required",
            'hardQuestion' => "required",
            'hardQuestionAnswers' => "required",
        ]);


        if ($request->onlyLink) {
            $request->validate([
                'link' => 'required',
            ]);
        } else {
            $request->validate([
                'content' => 'required',
            ]);
        }

        $course = Course::find($courseId);
        if (!Auth::user()->ownsCourse($course))
            return redirect()->back();

        $contentSource = null;
        if ($request->onlyLink) {
            $contentSource = $request->link;
        } else {
            $file = $request->file('content');
            $destinationPath = '/uploads';
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);

            $filePath = $destinationPath . '/' . $filename;

            $contentSource = Cloudinary::upload($filePath, [
                'resource_type' => 'auto',
            ])->getSecurePath();

            unlink($filePath);
        }

        $contentType = ContentType::where('name', $request->contentType)->first();

        $addedContent = $course->sections()->find($request->section)->contents()->create([
            'title' => $request->title,
            'source' => $contentSource,
            'content_type_id' => $contentType->id,
        ]);


        $checkQuestion = new Question();
        $checkQuestion->content_id = $addedContent->id;
        $checkQuestion->text = $request->checkQuestion;
        $checkQuestion->type = 'check';
        $checkQuestion->save();


        $correctCheckAnswer = $request->checkQuestionAnswers[0];
        foreach ($request->checkQuestionAnswers as $answer) {
            $checkQuestion->answers()->create([
                'text' => $answer,
                'is_correct' => $answer == $correctCheckAnswer,
            ]);
        }


        $easyQuestion = new Question();
        $easyQuestion->content_id = $addedContent->id;
        $easyQuestion->text = $request->easyQuestion;
        $easyQuestion->type = 'test';
        $easyQuestion->level = 'easy';
        $easyQuestion->save();

        $correctEasyAnswer = $request->easyQuestionAnswers[0];
        foreach ($request->easyQuestionAnswers as $answer) {
            $easyQuestion->answers()->create([
                'text' => $answer,
                'is_correct' => $answer == $correctEasyAnswer,
            ]);
        }


        $mediumQuestion = new Question();
        $mediumQuestion->content_id = $addedContent->id;
        $mediumQuestion->text = $request->mediumQuestion;
        $mediumQuestion->type = 'test';
        $mediumQuestion->level = 'medium';
        $mediumQuestion->save();

        $correctMediumAnswer = $request->mediumQuestionAnswers[0];
        foreach ($request->mediumQuestionAnswers as $answer) {
            $mediumQuestion->answers()->create([
                'text' => $answer,
                'is_correct' => $answer == $correctMediumAnswer,
            ]);
        }


        $hardQuestion = new Question();
        $hardQuestion->content_id = $addedContent->id;
        $hardQuestion->text = $request->hardQuestion;
        $hardQuestion->type = 'test';
        $hardQuestion->level = 'hard';
        $hardQuestion->save();

        $correctHardAnswer = $request->hardQuestionAnswers[0];
        foreach ($request->hardQuestionAnswers as $answer) {
            $hardQuestion->answers()->create([
                'text' => $answer,
                'is_correct' => $answer == $correctHardAnswer,
            ]);
        }

        return redirect()->route('courses.show', $courseId)->with('success', 'Content added successfully');
    }

    public function editContent(Request $request, $courseId, $contentId)
    {
        $course = Course::findOrFail($courseId);
        $sections = $course->sections()->get();

        // find course which section_id is equal to one of the sections of the course and content_id is equal to the contentId
        $content = Content::whereHas('section', function ($query) use ($sections) {
            $query->whereIn('id', $sections->pluck('id'));
        })->where('id', $contentId)->first();

        $checkQuestion = $content->questions()->where('type', 'check')->first();

        $easyQuestion = $content->questions()->where('type', 'test')->where('level', 'easy')->first();
        $mediumQuestion = $content->questions()->where('type', 'test')->where('level', 'medium')->first();
        $hardQuestion = $content->questions()->where('type', 'test')->where('level', 'hard')->first();



        if (!Auth::user()->ownsCourse($course) || !$content)
            return redirect()->back();

        return view(
            'teacher.courses.editContent',
            [
                'course' => $course, 'content' => $content,
                'checkQuestion' => $checkQuestion,
                'easyQuestion' => $easyQuestion,
                'mediumQuestion' => $mediumQuestion,
                'hardQuestion' => $hardQuestion
            ]
        );
    }

    public function updateContent(Request $request, $courseId, $contentId)
    {
        $request->validate([
            'title' => 'required',
            'section' => 'required',
            'checkQuestion' => "required",
            'checkQuestionAnswers' => "required",
            'easyQuestion' => "required",
            'easyQuestionAnswers' => "required",
            'mediumQuestion' => "required",
            'mediumQuestionAnswers' => "required",
            'hardQuestion' => "required",
            'hardQuestionAnswers' => "required",
        ]);


        if ($request->content) {
            $file = $request->file('content');
            $destinationPath = 'uploads';
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);

            $filePath = $destinationPath . '/' . $filename;

            $contentSource = Cloudinary::upload($filePath, [
                'resource_type' => 'auto',
            ])->getSecurePath();
        } else if ($request->link) {
            $contentSource = $request->link;
        } else {
            $contentSource = $request->source;
        }

        $course = Course::findOrFail($courseId);
        $sections = $course->sections()->get();

        // find course which section_id is equal to one of the sections of the course and content_id is equal to the contentId
        $content = Content::whereHas('section', function ($query) use ($sections) {
            $query->whereIn('id', $sections->pluck('id'));
        })->where('id', $contentId)->first();

        if (!Auth::user()->ownsCourse($course) || !$content) {
            return redirect()->back();
        }

        $contentType = ContentType::where('name', $request->contentType)->first();

        $content->title = $request->title;
        $content->section_id = $request->section;
        $content->source = $contentSource;
        if ($contentType)
            $content->content_type_id = $contentType->id;
        $content->save();

        $content->questions()->delete();

        $checkQuestion = new Question();
        $checkQuestion->content_id = $content->id;
        $checkQuestion->text = $request->checkQuestion;
        $checkQuestion->type = 'check';
        $checkQuestion->save();


        $correctCheckAnswer = $request->checkQuestionAnswers[0];
        foreach ($request->checkQuestionAnswers as $answer) {
            $checkQuestion->answers()->create([
                'text' => $answer,
                'is_correct' => $answer == $correctCheckAnswer,
            ]);
        }


        $easyQuestion = new Question();
        $easyQuestion->content_id = $content->id;
        $easyQuestion->text = $request->easyQuestion;
        $easyQuestion->type = 'test';
        $easyQuestion->level = 'easy';
        $easyQuestion->save();

        $correctEasyAnswer = $request->easyQuestionAnswers[0];
        foreach ($request->easyQuestionAnswers as $answer) {
            $easyQuestion->answers()->create([
                'text' => $answer,
                'is_correct' => $answer == $correctEasyAnswer,
            ]);
        }


        $mediumQuestion = new Question();
        $mediumQuestion->content_id = $content->id;
        $mediumQuestion->text = $request->mediumQuestion;
        $mediumQuestion->type = 'test';
        $mediumQuestion->level = 'medium';
        $mediumQuestion->save();

        $correctMediumAnswer = $request->mediumQuestionAnswers[0];
        foreach ($request->mediumQuestionAnswers as $answer) {
            $mediumQuestion->answers()->create([
                'text' => $answer,
                'is_correct' => $answer == $correctMediumAnswer,
            ]);
        }


        $hardQuestion = new Question();
        $hardQuestion->content_id = $content->id;
        $hardQuestion->text = $request->hardQuestion;
        $hardQuestion->type = 'test';
        $hardQuestion->level = 'hard';
        $hardQuestion->save();

        $correctHardAnswer = $request->hardQuestionAnswers[0];
        foreach ($request->hardQuestionAnswers as $answer) {
            $hardQuestion->answers()->create([
                'text' => $answer,
                'is_correct' => $answer == $correctHardAnswer,
            ]);
        }

        return redirect()->route('courses.show', $courseId)->with('success', 'Content updated successfully');
    }

    public function deleteContent(Request $request, $courseId, $contentId)
    {
        $course = Course::findOrFail($courseId);
        $sections = $course->sections()->get();

        // find course which section_id is equal to one of the sections of the course and content_id is equal to the contentId
        $content = Content::whereHas('section', function ($query) use ($sections) {
            $query->whereIn('id', $sections->pluck('id'));
        })->where('id', $contentId)->first();

        if (!Auth::user()->ownsCourse($course) || !$content) {
            return redirect()->back();
        }

        $content->delete();

        return redirect()->route('courses.show', $courseId)->with('success', 'Content deleted successfully');
    }
}
