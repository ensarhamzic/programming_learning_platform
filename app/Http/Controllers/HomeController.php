<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = Auth::user()->role->name;
        switch ($role) {
            case 'admin':
                return redirect('/admin/registrations');
                break;
            case 'teacher':
                return redirect('/teacher/courses');
                break;
            default:
                break;
        }
        return view('home');
    }
}
