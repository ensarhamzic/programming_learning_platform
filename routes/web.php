<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminRegistrationsController;
use App\Http\Controllers\ManageUsersController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\CoursesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['role:admin'])->group(function () {
    Route::get('admin/registrations', [AdminRegistrationsController::class, 'index'])->name('admin.registrations.index');
    Route::delete('admin/registrations/{id}', [AdminRegistrationsController::class, 'destroy'])->name('admin.registrations.destroy');
    Route::patch('admin/registrations/{id}', [AdminRegistrationsController::class, 'update'])->name('admin.registrations.update');

    Route::get('admin/users/', [ManageUsersController::class, 'index'])->name('admin.users.index');
    Route::delete('admin/users/{id}', [ManageUsersController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('admin/notifications/', [NotificationsController::class, 'index'])->name('admin.notifications.index');
    Route::get('admin/notifications/create', [NotificationsController::class, 'create'])->name('admin.notifications.create');
    Route::post('admin/notifications/', [NotificationsController::class, 'store'])->name('admin.notifications.store');
    Route::delete('admin/notifications/{id}', [NotificationsController::class, 'destroy'])->name('admin.notifications.destroy');
});

Route::middleware(['role:teacher'])->group(function () {
    Route::get('teacher/courses', [CoursesController::class, 'index'])->name('teacher.courses.index');
    Route::get('teacher/courses/create', [CoursesController::class, 'create'])->name('teacher.courses.create');
    Route::get('teacher/courses/{id}/edit', [CoursesController::class, 'edit'])->name('teacher.courses.edit');
    Route::put('teacher/courses/{id}/update', [CoursesController::class, 'update'])->name('teacher.courses.update');
    Route::post('teacher/courses/store', [CoursesController::class, 'store'])->name('teacher.courses.store');
    Route::post('teacher/courses/{id}/toggleActive', [CoursesController::class, 'toggleActive'])->name('teacher.courses.toggleActive');
    Route::delete('teacher/courses/{id}/', [CoursesController::class, 'destroy'])->name('teacher.courses.destroy');

    Route::get('teacher/courses/{id}/addSection', [CoursesController::class, 'addSection'])->name('teacher.courses.addSection');
    Route::post('teacher/courses/{id}/addSection', [CoursesController::class, 'storeSection'])->name('teacher.courses.storeSection');

    Route::get('teacher/courses/{id}/addContent', [CoursesController::class, 'addContent'])->name('teacher.courses.addContent');
    Route::post('teacher/courses/{id}/addContent', [CoursesController::class, 'storeContent'])->name('teacher.courses.storeContent');
});

Route::get('courses/{id}', [CoursesController::class, 'show'])->name('courses.show');
