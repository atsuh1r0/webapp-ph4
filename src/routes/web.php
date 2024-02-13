<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudyTimeController;

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


Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\StudyTimeController::class, 'index'])->name('study_time.index');
    Route::post('/store', [App\Http\Controllers\StudyTimeController::class, 'store'])->name('study_time.store');
    Route::get('/get-barChart-data', [StudyTimeController::class, 'getBarChartData']);
    Route::get('/get-languagesPieChart-data', [StudyTimeController::class, 'getLanguagesPieChartData']);
    Route::get('/get-contentsPieChart-data', [StudyTimeController::class, 'getContentsPieChartData']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
