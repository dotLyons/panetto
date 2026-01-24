<?php

use App\Livewire\AdminDashboard;
use App\Livewire\PublicMenu;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Ruta Admin (igual)
Route::get('/admin-panel', AdminDashboard::class)->name('admin.index');

// Ruta Pública Dinámica (Ej: /menu/bar-centro)
Route::get('/menu/{slug}', PublicMenu::class)->name('menu.show');

// Redirección opcional: si entran a la raíz, mándalos a un local por defecto o a una landing
Route::get('/', function () {
    return redirect()->route('menu.show', ['slug' => 'bar-centro']);
    // OJO: Asegúrate de crear un local con slug 'bar-centro' en la BD
});

//Route::get('/', function () {
//    return view('welcome');
//})->name('home');

//Route::view('dashboard', 'dashboard')
//    ->middleware(['auth', 'verified'])
//    ->name('dashboard');

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'The [public/storage] link has been connected';
});

require __DIR__ . '/settings.php';
