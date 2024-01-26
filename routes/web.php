<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;



// using controller
// welcome page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');

// blog page
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');

// create blog post
Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');

// store blog post to the database
Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');

// to single blog post
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

// to edit single blog post
Route::get('/blog/{post}/edit', [BlogController::class, 'edit'])->name('blog.edit');

// to update single blog post
Route::put('/blog/{post}', [BlogController::class, 'update'])->name('blog.update');

// to update single blog post
Route::delete('/blog/{post}', [BlogController::class, 'delete'])->name('blog.delete');

// using closure
// to about page 
Route::get('/about', function () {
    return view('about');
})->name('about');

// to contact page
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
