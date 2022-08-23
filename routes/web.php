<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [Controllers\SignUp::class, 'index']);
Route::post('/stu-signup', [Controllers\SignUp::class, 'getStudentData']);
Route::view('/signup', 'signup.teacher-signup');
Route::post('/tchr-signup', [Controllers\SignUp::class, 'getTeacherData']);
Route::post('/update-student/{id}', [Controllers\User::class, 'updateStudentData'])->name('update-student');
Route::post('/update-teacher/{id}', [Controllers\User::class, 'updateTeacherData'])->name('update-teacher');

Route::view('/signin', 'signin.login')->name('signin');
Route::post('/login', [Controllers\LogIn::class, 'checkUserAuth']);

Route::get('/dashboard', [Controllers\User::class, 'getDashboardData'])->name('dashboard');
Route::get('/logout', [Controllers\User::class, 'logout'])->name('logout');

/** Ajax Call */
Route::get('/get-subject', [Controllers\Subject::class, 'getSubjects']);
Route::get('/get-dashboard-data', [Controllers\Dashboard::class, 'getUsersData'])->name('get-dashboard-data');
Route::get('/get-single-user-data', [Controllers\Dashboard::class, 'getSingleUsersData']);
Route::post('/assign-teacher', [Controllers\Dashboard::class, 'assignTeacher']);
Route::post('/request-action', [Controllers\Dashboard::class, 'actionOnUserRequest']);
Route::get('/pending-request', [Controllers\Dashboard::class, 'getPendingRequest']);