<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/about', function () {
    return view('about');
})->middleware(['auth', 'verified'])->name('about');


Route::middleware('auth', 'verified')->group(function () {
    // Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::resource('users', UsersController::class);

    // Roles
    Route::resource('/roles', RolesController::class);
    
    // Permissions
    Route::resource('/permissions', PermissionsController::class);
});




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group([
    /* RoleCheck middleware usage example here */
    'middleware' => 'role:super admin,admin',
    'prefix' => 'product',
    'as' => 'product.',
], function () {
    Route::group([
        'prefix' => 'product-type',
        'as' => 'product-type.'
    ], function () {
         Route::get('/', function () {
            return "Product Type Index";
        })->name('product-type.index');
    });
});

require __DIR__.'/auth.php';
