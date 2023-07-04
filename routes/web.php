<?php

use App\Http\Controllers\Controller;
use App\Models\PracticePlace;
use App\Models\Student;
use App\Models\StudentPracticePlace;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect()->route('login'); //Buat redirect ke Login
});
Route::get('/register', function(){
    return redirect()->route('login');
});
Route::get('/dashboard',[Controller::class, 'dashboard'])->middleware(['auth'])->name('dashboard');
Route::get('profile', [Controller::class,'editProfile'])->middleware('auth')->name('edit.profile');
Route::post('profile-update', [Controller::class,'updateProfile'])->middleware('auth')->name('update.profile');

require __DIR__ . '/auth.php';
