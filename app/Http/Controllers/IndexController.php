<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

use App\Models\Notification;
use App\Models\User;

class IndexController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('created_at', '>=', now()->subWeek())->orderBy('created_at', 'desc')->get();
        $courses = Course::where('active', 1)->where('created_at', '>=', now()->subWeek())->where('active', true)->orderBy('created_at', 'desc')->get();
        // get 5 best rated courses
        $bestRatedCourses = $courses->sortByDesc(function ($course, $key) {
            return $course->ratings->avg('rating');
        })->take(5);
        return view('welcome', compact('notifications', 'courses', 'bestRatedCourses'));
    }

    public function search(Request $request)
    {
        $search = $request->get('query');
        $courses = Course::where('title', 'like', '%' . $search . '%')->where('active', 1)->get();
        $students = User::where('name', 'like', '%' . $search . '%')->whereHas('role', function ($query) {
            $query->where('name', 'student');
        })->get();
        $teachers = User::where('name', 'like', '%' . $search . '%')->where('approved', 1)->whereHas('role', function ($query) {
            $query->where('name', 'teacher');
        })->get();
        return view('search', compact('courses', 'search', 'students', 'teachers'));
    }
}
