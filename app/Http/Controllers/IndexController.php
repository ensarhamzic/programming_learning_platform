<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

use App\Models\Notification;

class IndexController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('created_at', '>=', now()->subWeek())->orderBy('created_at', 'desc')->get();
        $courses = Course::where('created_at', '>=', now()->subWeek())->where('active', true)->orderBy('created_at', 'desc')->get();
        return view('welcome', compact('notifications', 'courses'));
    }
}
