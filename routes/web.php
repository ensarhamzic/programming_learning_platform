<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminRegistrationsController;
use App\Http\Controllers\ManageUsersController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\IndexController;

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

Route::get('/', [IndexController::class, 'index'])->name('index');

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
    Route::get('teacher/courses/{id}/attendants', [CoursesController::class, 'showAttendants'])->name('teacher.courses.attendants');
    Route::put('teacher/courses/{id}/update', [CoursesController::class, 'update'])->name('teacher.courses.update');
    Route::post('teacher/courses/store', [CoursesController::class, 'store'])->name('teacher.courses.store');
    Route::post('teacher/courses/{id}/toggleActive', [CoursesController::class, 'toggleActive'])->name('teacher.courses.toggleActive');
    Route::delete('teacher/courses/{id}/', [CoursesController::class, 'destroy'])->name('teacher.courses.destroy');

    Route::get('teacher/courses/{id}/test/{userJMBG}/results', [CoursesController::class, 'userTestResults'])->name('teacher.courses.userTestResults');

    Route::get('teacher/courses/{id}/addSection', [CoursesController::class, 'addSection'])->name('teacher.courses.addSection');
    Route::post('teacher/courses/{id}/addSection', [CoursesController::class, 'storeSection'])->name('teacher.courses.storeSection');
    Route::get('teacher/courses/{id}/editSection/{sectionId}', [CoursesController::class, 'editSection'])->name('teacher.courses.editSection');
    Route::put('teacher/courses/{id}/editSection/{sectionId}', [CoursesController::class, 'updateSection'])->name('teacher.courses.updateSection');
    Route::delete('teacher/courses/{id}/deleteSection/{sectionId}', [CoursesController::class, 'deleteSection'])->name('teacher.courses.deleteSection');

    Route::post('teacher/courses/{id}/complete', [CoursesController::class, 'complete'])->name('teacher.courses.complete');
    Route::post('teacher/courses/{id}/incomplete', [CoursesController::class, 'incomplete'])->name('teacher.courses.incomplete');

    Route::get('teacher/courses/{id}/addContent', [CoursesController::class, 'addContent'])->name('teacher.courses.addContent');
    Route::post('teacher/courses/{id}/addContent', [CoursesController::class, 'storeContent'])->name('teacher.courses.storeContent');
    Route::get('teacher/courses/{id}/editContent/{contentId}', [CoursesController::class, 'editContent'])->name('teacher.courses.editContent');
    Route::put('teacher/courses/{id}/editContent/{contentId}', [CoursesController::class, 'updateContent'])->name('teacher.courses.updateContent');
    Route::delete('teacher/courses/{id}/deleteContent/{contentId}', [CoursesController::class, 'deleteContent'])->name('teacher.courses.deleteContent');
});

Route::get('courses/search', [CoursesController::class, 'search'])->name('courses.search');
Route::post('courses/{id}/rate', [CoursesController::class, 'rate'])->name('courses.rate');
Route::get('courses/{id}', [CoursesController::class, 'show'])->name('courses.show');
Route::get('courses/{id}/content/{contentId}/question', [CoursesController::class, 'showCheckQuestion'])->name('courses.checkQuestion');
Route::post('courses/{id}/content/{contentId}/question/{questionId}', [CoursesController::class, 'answerQuestion'])->name('courses.questions.answer');
Route::post('courses/{id}/enroll', [CoursesController::class, 'enroll'])->name('courses.enroll');
Route::delete('courses/{id}/unenroll', [CoursesController::class, 'unenroll'])->name('courses.unenroll');
Route::post('courses/{id}/content/{contentId}/complete', [CoursesController::class, 'completeContent'])->name('courses.completeContent');
Route::get('courses/{id}/test', [CoursesController::class, 'showTest'])->name('courses.test');
Route::get('courses/{id}/test/results', [CoursesController::class, 'testResults'])->name('courses.test.results');
Route::post('courses/{id}/test', [CoursesController::class, 'endTest'])->name('courses.test.end');
Route::get('notifications/{id}', [NotificationsController::class, 'show'])->name('notifications.show');
