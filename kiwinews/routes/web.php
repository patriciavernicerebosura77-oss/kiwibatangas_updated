<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NewsController;

// Route para sa Single News Page
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');

// Public Homepage Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Admin Login Routes
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('login');

Route::post('/admin/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended('/admin/dashboard')
            ->with('success', 'Logged in successfully!');
    }

    return back()->withErrors([
        'email' => 'Ang mga kredensyal na ito ay hindi tugma sa aming mga tala.',
    ])->onlyInput('email');
})->name('admin.login.submit');

// Logout Route para sa Admin
Route::post('/admin/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/admin/login')->with('success', 'Successfully logged out!');
})->name('admin.logout');

// Admin Protected Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Route
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Articles Management Routes
    Route::post('/articles', [AdminController::class, 'storeArticle'])->name('articles.store');
    Route::get('/articles/{id}/edit', [AdminController::class, 'editArticle'])->name('articles.edit');
    Route::put('/articles/{id}', [AdminController::class, 'updateArticle'])->name('articles.update');
    Route::delete('/articles/{id}', [AdminController::class, 'destroyArticle'])->name('articles.destroy');

    // Categories Management Routes
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');
});