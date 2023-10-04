<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(FileController::class)
    ->middleware('auth')
    ->prefix('files')
    ->name('files.')
    ->group(function(){
    Route::get('index', 'index')->name('index');
    Route::post('store/{object}', 'store')->name('store');
    Route::put('update/{object}', 'update')->name('update');
    Route::post('upload/{object}', 'upload')->name('upload');
    Route::get('download/{file}', 'download')->name('download');
    Route::delete('delete/{object}', 'destroy')->name('delete');
});

Route::controller(TeamController::class)
    ->middleware('auth')
    ->prefix('teams')
    ->name('teams.')
    ->group(function(){
    Route::get('index', 'index')->name('index');
    Route::post('store', 'store')->name('store');
    Route::put('update/{team}', 'update')->name('update');
    Route::delete('delete/{team}', 'destroy')->name('delete');
});

Route::controller(UserController::class)
    ->middleware('auth')
    ->prefix('users')
    ->name('users.')
    ->group(function(){
    Route::get('index', 'index')->name('index');
    Route::post('store', 'store')->name('store');
    Route::put('update/{user}', 'update')->name('update');
    Route::delete('delete/{user}', 'destroy')->name('delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
