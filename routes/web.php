<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ProjectController;
use App\Http\Controllers\Public\BlogController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectAdminController;
use App\Http\Controllers\Admin\SkillAdminController;
use App\Http\Controllers\Admin\ExperienceAdminController;
use App\Http\Controllers\Admin\CertificationAdminController;
use App\Http\Controllers\Admin\BlogAdminController;
use App\Http\Controllers\Admin\MessageAdminController;
use App\Http\Controllers\Admin\SettingAdminController;

Route::get('/',                [HomeController::class, 'index'])->name('home');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/blog',            [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}',     [BlogController::class, 'show'])->name('blog.show');
Route::post('/contact',        [ContactController::class, 'send'])->name('contact.send')
     ->middleware('throttle:5,60');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login',  [AdminAuth::class, 'showLogin'])->name('login');
        Route::post('login', [AdminAuth::class, 'login'])->name('login.post');
    });
    Route::post('logout', [AdminAuth::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('projects',       ProjectAdminController::class);
        Route::post('projects/{project}/toggle-featured', [ProjectAdminController::class, 'toggleFeatured'])->name('projects.toggle-featured');
        Route::resource('skills',         SkillAdminController::class)->except(['show']);
        Route::post('skills/reorder',     [SkillAdminController::class, 'reorder'])->name('skills.reorder');
        Route::resource('experience',     ExperienceAdminController::class)->except(['show']);
        Route::resource('certifications', CertificationAdminController::class)->except(['show']);
        Route::resource('blog',           BlogAdminController::class);
        Route::get('messages',             [MessageAdminController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}',   [MessageAdminController::class, 'show'])->name('messages.show');
        Route::delete('messages/{message}',[MessageAdminController::class,'destroy'])->name('messages.destroy');
        Route::patch('messages/{message}/read',[MessageAdminController::class,'markRead'])->name('messages.read');
        Route::get('settings',             [SettingAdminController::class, 'index'])->name('settings.index');
        Route::put('settings',             [SettingAdminController::class, 'update'])->name('settings.update');
    });
});
