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
    Route::get('teacher/courses/create', [CoursesController::class, 'create'])->name('teacher.courses.create');
    Route::post('teacher/courses/store', [CoursesController::class, 'store'])->name('teacher.courses.store');
});
