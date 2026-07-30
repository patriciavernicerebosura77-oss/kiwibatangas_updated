<?php

use App\Http\Controllers\HomeController;

use App\Http\Controllers\AdminController; // O kung saan mo ilalagay ang login logic

// Para sa pagpapakita ng login page
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

// Para sa pag-proseso ng login (POST request)
Route::post('/admin/login', function (\Illuminate\Http\Request $request) {
    // Ilagay dito ang pansamantalang logic o i-redirect sa dashboard
    return redirect('/admin/dashboard')->with('success', 'Logged in successfully!');
})->name('admin.login.submit');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/', [HomeController::class, 'index']);