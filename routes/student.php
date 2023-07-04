<?php

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

// Route::get('download', [StudentController::class, 'exportStudentJurnal']);
Route::prefix('student')->middleware(['auth'])->group(function(){
    Route::get('/', [StudentController::class, 'index'])->name('student.index');
    Route::get('export', [StudentController::class, 'exportStudent'])->name('student.export');

    Route::get('create', [StudentController::class, 'create'])->name('student.create');
    Route::post('save', [StudentController::class, 'store'])->name('student.save');
    Route::post('update/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::get('edit/{id}', [StudentController::class, 'edit'] )->name('student.edit');
    Route::post('delete/{id}', [StudentController::class, 'delete']);
    Route::get('certificate', [StudentController::class, 'showCertificate'])->name('student.certificate')->middleware('role:student');
    Route::get('download-certificate', [StudentController::class, 'downloadCertificate'])->name('student.certificate.download')->middleware('role:student');






    //Presensi
    Route::get('present', [StudentController::class, 'listPresence'])->middleware('role:company|student|teacher')->name('present.index');
    Route::get('present/{slug}', [StudentController::class, 'presentation'])->middleware('role:student')->name('present.lock');
    Route::get('present/detail/{id}', [StudentController::class, 'detailPresence'])->name('present.detail')->middleware('role:company|student|teacher');
    Route::post('save-present/{type}', [StudentController::class, 'savePresentation'])->name('present.store')->middleware('role:student');


    //Jurnal
    Route::prefix('jurnal')->group(function(){
        Route::get('create', [StudentController::class, 'createStudentJurnal'])->name('student.jurnal.create')->middleware('role:student');
        Route::post('save', [StudentController::class, 'saveStudentJurnal'])->name('student.jurnal.save')->middleware('role:student');
        Route::get('/', [StudentController::class,'listStudentJurnal'])->name('student.jurnal.list')->middleware('role:student|teacher|company');
        Route::get('/detail/{id}', [StudentController::class, 'detailJurnal'])->name('student.jurnal.detail')->middleware('role:student|teacher|company');
        Route::get('/{id}', [StudentController::class, 'studentJurnalList'])->name('student.jurnal.lists');
        Route::get('edit/{id}', [StudentController::class, 'studentJurnalEdit'])->name('student.jurnal.edit');
        Route::post('update/{id}', [StudentController::class, 'studentJurnalUpdate'])->name('student.jurnal.update');
    });
});
