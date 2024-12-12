<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConcessionController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

route::get('/',[HomeController::class,'home']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


route::get('admin/dashboard', [HomeController::class,'index'])->
    middleware(['auth','admin']);

Route::resource('concessions', ConcessionController::class)
    ->middleware(['auth', 'admin'])
    ->names([
        'index' => 'concessions.index',
        'create' => 'concessions.create',
        'store' => 'concessions.store',
        'show' => 'concessions.show',
        'edit' => 'concessions.edit',
        'update' => 'concessions.update',
        'destroy' => 'concessions.destroy'
    ]);

Route::resource('orders', OrderController::class)
    ->middleware(['auth', 'admin'])
    ->names([
        'index' => 'orders.index',
        'create' => 'orders.create',
        'store' => 'orders.store',
        'show' => 'orders.show',
        'edit' => 'orders.edit',
        'update' => 'orders.update',
        'destroy' => 'orders.destroy'
    ]);
