<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/article', [HomeController::class, 'article'])->name('article.index');
Route::get('/article/{id}', [HomeController::class, 'showArticle'])->name('article.show');
Route::get('/gallery/{id}', [HomeController::class, 'showGallery'])->name('gallery.show');

Route::get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/posts/{post:slug}', [PostController::class,'show'])->name('posts.show');
Route::get('/galleries', [GalleryController::class,'index'])->name('galleries.index');
Route::get('/galleries/{gallery:slug}', [GalleryController::class,'show'])->name('galleries.show');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
        // Posts & Galleries
        Route::resource('posts', AdminPostController::class);
        Route::resource('galleries', AdminGalleryController::class);
        
        // Articles
        Route::resource('article', ArticleController::class)->except(['show']);
        Route::post('article/generate-slug', [ArticleController::class, 'generateSlug'])->name('article.generate-slug');
        Route::post('article/upload-image', [ArticleController::class, 'uploadImage'])->name('article.upload-image');
        Route::post('article/{article}/publish', [ArticleController::class, 'publish'])->name('article.publish');
        Route::post('article/{article}/archive', [ArticleController::class, 'archive'])->name('article.archive');

        // Admin Dashboard with article filter
        Route::get('/dashboard', [ArticleController::class, 'dashboard'])->name('dashboard');
    });

require __DIR__.'/auth.php';