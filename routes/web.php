<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LabController;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\BookController;

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

Route::get('/', function () {
    return view('welcome');
});

//home route
Route::get('home', [LabController::class, 'index']);
Route::post('home/store', [LabController::class, 'store']);
Route::post('home/destroy', [LabController::class, 'destroy']);


//books route
Route::get('books', [BookController::class, 'index']);
Route::post('books/store', [BookController::class, 'store']);
Route::post('books/destroy', [BookController::class, 'destroy']);
Route::get('books/edit/{id}', [BookController::class, 'edit']);
Route::post('books/update', [BookController::class, 'update']);

//student list route
Route::get('students', [StudentController::class, 'index']);
Route::post('students/store', [StudentController::class, 'store']);
Route::post('students/destroy', [StudentController::class, 'destroy']);
Route::get('students/edit/{id}', [StudentController::class, 'edit']);
Route::post('students/update', [StudentController::class, 'update']);
