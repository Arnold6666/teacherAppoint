<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// // 會員
// Route::get('/register', function () { return view('register'); });
// Route::get('/login', function () { return view('login'); })->name('login');
// Route::get('/logout',  [UserController::class, 'logout']);
// Route::post('/register', [UserController::class, 'create']);
// Route::post('/login', [UserController::class, 'login']);

// // 老師
// Route::get('/', [TeacherController::class, 'index']);
// Route::get('/teacher/{id}', [TeacherController::class, 'show'])->middleware('auth');

// // 課程
// Route::post('/curriculum/create', [CurriculumController::class, 'store'])->middleware('auth');
// Route::post('/curriculum/refund', [CurriculumController::class, 'refund'])->name('curriculum.refund')->middleware('auth');
// Route::get('/curriculum/show', [CurriculumController::class, 'show'])->middleware('auth');
// Route::delete('/curriculum/{id}', [CurriculumController::class, 'destroy'])->name('curriculum.destroy');
// Route::patch('/curriculum/{id}', [CurriculumController::class, 'update'])->name('curriculum.update');