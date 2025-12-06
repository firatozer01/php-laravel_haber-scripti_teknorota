<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // AJAX Image Upload for Question Editor
    Route::post('/questions/upload-image', [\App\Http\Controllers\QuestionImageController::class, 'store'])->name('questions.upload.image');
});

// Social Auth
Route::get('auth/google', [\App\Http\Controllers\Auth\SocialAuthController::class, 'redirect'])->name('auth.google');
Route::get('auth/google/callback', [\App\Http\Controllers\Auth\SocialAuthController::class, 'callback']);

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/category/{category:slug}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');
Route::get('/news', [\App\Http\Controllers\ArticleController::class, 'index'])->name('articles.index');
Route::get('/videos', [\App\Http\Controllers\VideoController::class, 'index'])->name('videos.index');
Route::get('/about', \App\Http\Controllers\AboutController::class)->name('about');

// Questions Routes
Route::get('/questions', [\App\Http\Controllers\QuestionController::class, 'index'])->name('questions.index');
Route::get('/questions/ask', [\App\Http\Controllers\QuestionController::class, 'create'])->name('questions.create')->middleware('auth');
Route::post('/questions', [\App\Http\Controllers\QuestionController::class, 'store'])->name('questions.store')->middleware('auth');
Route::get('/questions/{question}', [\App\Http\Controllers\QuestionController::class, 'show'])->name('questions.show');
Route::post('/questions/{question}/comment', [\App\Http\Controllers\QuestionController::class, 'storeComment'])->name('questions.comment')->middleware('auth');

Route::get('/article/{article:slug}', [\App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');
Route::post('/article/{article:slug}/comment', [\App\Http\Controllers\ArticleController::class, 'storeComment'])->name('articles.comment')->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
