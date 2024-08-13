<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


/*** Kalaiarasu added  *****/
// Route::middleware(['auth'])->get('/', function () {
//     return view('welcome');
// })->name('home');


/**General user routes **/
Route::middleware(['auth', 'verified'])->get('/dashboard', [ProfileController::class, 'edit'])->name('dashboard');

Route::get('/', [PageController::class, 'homepage'])->name('home');

/**Admin routes **/
Route::middleware('adminAuth')->prefix('admin')->group(function(){
    Route::get('/dashboard', [ProfileController::class, 'edit'])->name('adminDashboardShow');
});