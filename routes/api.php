<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassRoomController;
use App\Http\Controllers\MyparentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;

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

Route::post("student/addStudent", [StudentController::class, "addStudent"]);
Route::post("student/login", [StudentController::class, "login"]);

Route::post("admin/register", [UserController::class, "register"]);
Route::post("admin/login", [UserController::class, "login"]);
Route::post("teacher/addStudent", [TeacherController::class, "addTeacher"]);
Route::post("teacher/login", [TeacherController::class, "login"]);

Route::group(["middleware" => ["auth:sanctum"]], function () {

    Route::get("student/profile", [StudentController::class, "profile"]);
    Route::post("student/update", [StudentController::class, "update"]);
    Route::get("student/logout", [StudentController::class, "logout"]);

    Route::get("admin/profile", [UserController::class, "profile"]);
    Route::post("admin/update", [UserController::class, "update"]);
    Route::get("admin/logout", [UserController::class, "logout"]);

    Route::get("teacher/profile", [TeacherController::class, "profile"]);
    Route::post("teacher/update", [TeacherController::class, "update"]);
    Route::get("teacher/logout", [TeacherController::class, "logout"]);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
