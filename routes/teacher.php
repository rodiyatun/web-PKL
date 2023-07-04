<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

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
Route::prefix('teacher')->controller()->middleware('auth')->group(function(){
    Route::get('/', [TeacherController::class, 'index'])->name('teacher.index')->middleware('role:Admin');
    Route::get('create', [TeacherController::class, 'create'])->name('teacher.create')->middleware('role:Admin');
    Route::post('store', [TeacherController::class, 'store'])->name('teacher.store')->middleware('role:Admin');
    Route::get('edit/{id}', [TeacherController::class, 'edit'])->name('teacher.edit')->middleware('role:Admin');
    Route::post('update/{id}', [TeacherController::class, 'update'])->name('teacher.update')->middleware('role:Admin');
    Route::get('jurnal', [TeacherController::class, 'jurnalList'])->name('teacher.jurnal.list')->middleware('role:teacher');
    Route::get('jurnal/create/{id}', [TeacherController::class, 'createTeacherJurnal'])->name('teacher.jurnal.create')->middleware('role:teacher');
    Route::get('jurnal/edit/{id}', [TeacherController::class, 'jurnalEdit'])->name('teacher.jurnal.edit');
    Route::post('jurnal/save', [TeacherController::class, 'storeTeacherJurnal'])->name('teacher.jurnal.save')->middleware('role:teacher');
    Route::get('jurnal/student/{id}', [TeacherController::class, 'jurnalStudentList'])->name('teacher.jurnal.student.list');
    Route::get('jurnal/detail/{id}', [TeacherController::class, 'jurnalStudentDetail'])->name('teacher.jurnal.student.detail');
    Route::post('jurnal/upload/{id}', [TeacherController::class, 'jurnalUpdate'])->name('teacher.jurnal.update');
});
