<?php

use App\Livewire\AdminDashboard;
use App\Livewire\PublicMenu;
use App\Livewire\RaffleForm;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Ruta Admin (igual)
Route::get('/admin-panel', AdminDashboard::class)->name('admin.index');

// Nota: la página de participantes ahora se gestiona desde el AdminDashboard
// (vista integrada, protegida por la sesión administrativa). La ruta pública
// previa fue removida para evitar acceso público.

// Ruta Pública Dinámica (Ej: /menu/bar-centro)
Route::get('/menu/{slug}', PublicMenu::class)->name('menu.show');

Route::get('/sorteo', RaffleForm::class)->name('raffle.form');

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

// ... tus otras rutas ...

Route::get('/sorteo/qr', function () {
    // 1. Obtenemos la URL del sorteo
    $url = route('raffle.form');

    // 2. Configuramos el generador (Igual que en el Dashboard)
    $renderer = new ImageRenderer(
        new RendererStyle(500), // Tamaño grande para impresión
        new SvgImageBackEnd()
    );
    $writer = new Writer($renderer);

    // 3. Generamos el contenido SVG
    $svgContent = $writer->writeString($url);

    // 4. Forzamos la descarga
    return response()->streamDownload(function () use ($svgContent) {
        echo $svgContent;
    }, 'qr-sorteo-panetto.svg');
});

// Redirección opcional: si entran a la raíz, mándalos a un local por defecto o a una landing
Route::get('/', function () {
    return redirect()->route('admin.index');
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
