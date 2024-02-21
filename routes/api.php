<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

// Mentor endpoints
Route::post("/mentors", [\App\Http\Controllers\MentorController::class, "create"]);
Route::get("/mentors", [\App\Http\Controllers\MentorController::class, "getAll"]);
Route::patch("/mentors/{id}", [\App\Http\Controllers\MentorController::class, "update"]);
Route::get("/mentors/{id}", [\App\Http\Controllers\MentorController::class, "getById"]);
Route::delete("/mentors/{id}", [\App\Http\Controllers\MentorController::class, "remove"]);

// Course endpoints
Route::post("/courses", [\App\Http\Controllers\CourseController::class, "create"]);
Route::get("/courses", [\App\Http\Controllers\CourseController::class, "getAll"]);
Route::patch("/courses/{id}", [\App\Http\Controllers\CourseController::class, "update"]);
Route::delete("/courses/{id}", [\App\Http\Controllers\CourseController::class, "remove"]);

// Chapter endpoints
Route::post("/chapters", [\App\Http\Controllers\ChapterController::class, "create"]);
Route::get("/chapters", [\App\Http\Controllers\ChapterController::class, "getAll"]);
Route::get("/chapters/{id}", [\App\Http\Controllers\ChapterController::class, "getById"]);
Route::patch("/chapters/{id}", [\App\Http\Controllers\ChapterController::class, "update"]);
Route::delete("/chapters/{id}", [\App\Http\Controllers\ChapterController::class, "remove"]);

// Lesson endpoints
Route::post("/lessons", [\App\Http\Controllers\LessonController::class, "create"]);
Route::get("/lessons", [\App\Http\Controllers\LessonController::class, "getAll"]);
Route::patch("/lessons/{id}", [\App\Http\Controllers\LessonController::class, "update"]);
Route::get("/lessons/{id}", [\App\Http\Controllers\LessonController::class, "getById"]);
Route::delete("/lessons/{id}", [\App\Http\Controllers\LessonController::class, "remove"]);

// Image course endpoints
Route::post("/image-courses", [\App\Http\Controllers\ImageCourseController::class, "create"]);
Route::delete("/image-courses/{id}", [\App\Http\Controllers\ImageCourseController::class, "remove"]);

// My course endpoints
Route::post("/my-courses", [\App\Http\Controllers\MyCourseController::class, "create"]);
Route::get("/my-courses", [\App\Http\Controllers\MyCourseController::class, "getAll"]);

// Review endpoints
Route::post("/reviews", [\App\Http\Controllers\ReviewController::class, "create"]);
Route::patch("/reviews/{id}", [\App\Http\Controllers\ReviewController::class, "update"]);
Route::delete("/reviews/{id}", [\App\Http\Controllers\ReviewController::class, "remove"]);
