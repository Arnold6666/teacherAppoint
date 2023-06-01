<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyDomainMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// 會員
Route::post('/register', [UserController::class, 'create']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:api');

// 課程
Route::post('/curriculum/store', [CurriculumController::class, 'store'])->middleware('auth:api');
Route::get('/curriculum/show', [CurriculumController::class, 'show'])->middleware('auth:api');
Route::get('/curriculum/unpay', [CurriculumController::class, 'unpay']);
Route::post('/curriculum/pay', [CurriculumController::class, 'pay']);
Route::post('/curriculum/callback', [CurriculumController::class, 'callback']);
Route::patch('/curriculum/{id}', [CurriculumController::class, 'update'])->middleware('auth:api');
Route::delete('/curriculum/{id}', [CurriculumController::class, 'destroy'])->middleware('auth:api');
Route::post('/curriculum/refund/{id}', [CurriculumController::class, 'refund'])->middleware('auth:api');

// 老師
Route::get('/teacher/all', [TeacherController::class, 'index']);
Route::get('/teacher/{id}', [TeacherController::class, 'show'])->middleware('auth:api');
// Route::post('/teacher', [TeacherController::class, 'store'])->middleware(VerifyDomainMiddleware::class);
Route::post('/teacher', [TeacherController::class, 'store']);
Route::patch('/teacher/{id}', [TeacherController::class, 'update']);
Route::delete('/teacher/{id}', [TeacherController::class, 'destroy']);

// line
Route::post('/line',[LineController::class, 'index']);