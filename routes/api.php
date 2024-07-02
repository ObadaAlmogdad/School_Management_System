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

Route::post("addStudent", [StudentController::class, "addStudent"]);
Route::post("login", [StudentController::class, "login"]);

Route::group(["middleware" => ["auth:sanctum"]], function () {

    Route::get("profile", [StudentController::class, "profile"]);
    Route::post("update", [StudentController::class, "update"]);
    Route::get("logout", [StudentController::class, "logout"]);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
