<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\StudentController;
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
Route::prefix('company')->middleware('auth','role:Admin|company|teacher')->group(function(){
    Route::get('/', [CompanyController::class, 'index'])->name('company.index')->middleware('role:Admin|teacher');
    Route::get('detail/{id}', [CompanyController::class, 'listStudent'])->name('company.detail')->middleware('role:teacher');
    Route::get('create', [CompanyController::class, 'create'])->name('company.create')->middleware('role:Admin');
    Route::post('store', [CompanyController::class, 'store'])->name('company.store')->middleware('role:Admin');
    Route::get('edit/{id}',[ CompanyController::class, 'edit'])->name('company.edit')->middleware('role:Admin');
    Route::post('update/{id}', [CompanyController::class, 'update'])->name('company.update')->middleware('role:Admin');
    Route::post('delete/{id}', [CompanyController::class, 'delete'])->name('company.delete')->middleware('role:Admin');
    Route::post('assessment/store/{id}', [CompanyController::class, 'storeCompanyAssessment'])->name('company.assessment.store')->middleware('role:teacher|company');
    Route::get('assessment/{id}', [CompanyController::class, 'companyAssessment'])->name('company.assessment')->middleware('role:teacher|company');

    Route::get('assign/{id}', [StudentController::class, 'assignPracticePlace'])->name('student.assign')->middleware('role:Admin');

    Route::get('assigned/{id}', [StudentController::class, 'listStudentAssigned']);
    Route::get('teacher/assigned/{id}', [CompanyController::class, 'listTeacherAssigned']);

    Route::post('teacher/assign-save/{id}', [CompanyController::class, 'postAssignTeacher']);
    Route::post('assign-save/{id}', [StudentController::class, 'postAssignPracticePlace']);

    Route::post('assign-delete/{id}', [StudentController::class, 'deleteStudentAssigned']);
    Route::post('teacher/assign-delete/{id}', [CompanyController::class, 'deleteTeacherAssigned']);

});
