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
    Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
        Route::post('/admin/user/register', [App\Http\Controllers\AdminController::class, 'registerUser'])->name('admin.user.register');
        Route::delete('/admin/user/delete', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.user.delete');
        Route::post('/admin/language/register', [App\Http\Controllers\AdminController::class, 'registerLanguage'])->name('admin.language.register');
        Route::delete('/admin/language/delete', [App\Http\Controllers\AdminController::class, 'deleteLanguage'])->name('admin.language.delete');
        Route::post('/admin/content/register', [App\Http\Controllers\AdminController::class, 'registerContent'])->name('admin.content.register');
        Route::delete('/admin/content/delete', [App\Http\Controllers\AdminController::class, 'deleteContent'])->name('admin.content.delete');
    });

    Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{id}', [App\Http\Controllers\NewsController::class, 'detail'])->name('news.detail');
});

require __DIR__ . '/auth.php';
