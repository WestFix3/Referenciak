<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoomController;

// Alapértelmezett útvonal a főoldalhoz
Route::get('/', [HomeController::class, 'index'])->name('index');

// Dashboard route (bejelentkezés után elérhető)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profil kezelése (csak bejelentkezett felhasználóknak)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dolgozók route-jai (az `employees` route-okat egyszer regisztráltam a resource-szal)
Route::middleware('auth')->group(function () {
    Route::resource('employees', EmployeeController::class)->except(['show']);  // CRUD műveletek automatikusan regisztrálva
    Route::get('entries/{user}', [EntryController::class, 'index'])->name('entries.index');
});

// Admin jogosultságokkal rendelkező felhasználóknak
Route::middleware(['auth', 'admin'])->group(function () {
    // **Fontos változtatás!** Itt biztosítjuk, hogy az `employees/create` és `employees/store` csak admin felhasználóknak elérhetőek
    Route::get('employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('employees', [EmployeeController::class, 'store'])->name('employees.store');
    // Új felhasználó létrehozása admin jogosultsággal
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    // Dolgozó szerkesztése
    Route::get('employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    // Dolgozó törlése
    Route::delete('employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    // Belépések kiirása
    Route::get('entries/{user}', [EmployeeController::class, 'showEntries'])->name('entries.index');
    // Munkakör létrehozása
    Route::get('/positions/create', [PositionController::class, 'create'])->name('positions.create');
    Route::post('/positions', [PositionController::class, 'store'])->name('positions.store');
    // Munkakör szerkeztése
    Route::get('/positions/{position}/edit', [PositionController::class, 'edit'])->name('positions.edit');
    Route::put('/positions/{position}', [PositionController::class, 'update'])->name('positions.update');

    // Szobák létrehozása
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    // Szobák szerkeztése
    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('positions', PositionController::class)->except(['show']);
    Route::get('positions/{position}', [PositionController::class, 'show'])->name('positions.show');
    Route::resource('rooms', RoomController::class)->middleware('auth');
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/{room}/entries', [RoomController::class, 'entryHistory'])->name('rooms.entries');
    Route::get('/rooms/{room}/entry-history', [RoomController::class, 'entryHistory'])->middleware('admin');
});

// A végén lévő auth.php fájl hívása biztosítja a bejelentkezési és regisztrációs route-okat.
require __DIR__.'/auth.php';
