<?php

use App\Http\Controllers\GoogleController;
use App\Livewire\AdminDashboard;
use App\Livewire\PublicMenu;
use App\Livewire\RaffleForm;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Livewire\SurveyForm;
use App\Livewire\SalonControlForm;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Auth;

// Ruta Admin (protegida por autenticación)
Route::get('/admin-panel', AdminDashboard::class)->name('admin.index')->middleware('auth');

// Nota: la página de participantes ahora se gestiona desde el AdminDashboard
// (vista integrada, protegida por la sesión administrativa). La ruta pública
// previa fue removida para evitar acceso público.

// Ruta Pública Dinámica (Ej: /menu/bar-centro)
Route::get('/menu/{slug}', PublicMenu::class)->name('menu.show');

Route::get('/sorteo', RaffleForm::class)->name('raffle.form');
Route::get('/control-salon', SalonControlForm::class)->name('salon-control.form');

Route::get('/salon-control/pdf/{id}', function ($id) {
    if (!Auth::check()) abort(403);
    $control = \App\Models\SalonControl::findOrFail($id);
    
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.salon-control', compact('control'));
    return $pdf->stream('planilla-control-'.$control->id.'.pdf');
})->name('salon-control.pdf')->middleware('auth');

Route::get('/sorteo/qr', function () {
    $url = route('raffle.form');

    $renderer = new ImageRenderer(
        new RendererStyle(500), // Tamaño grande para impresión
        new SvgImageBackEnd()
    );
    $writer = new Writer($renderer);

    $svgContent = $writer->writeString($url);

    return response()->streamDownload(function () use ($svgContent) {
        echo $svgContent;
    }, 'qr-sorteo-panetto.svg');
})->name('raffle.qr');

Route::get('/encuesta', SurveyForm::class)->name('survey.form');

Route::get('/encuesta/qr', function () {
    $url = route('survey.form');

    $renderer = new \BaconQrCode\Renderer\ImageRenderer(
        new \BaconQrCode\Renderer\RendererStyle\RendererStyle(500),
        new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
    );
    $writer = new \BaconQrCode\Writer($renderer);
    $svgContent = $writer->writeString($url);

    return response()->streamDownload(function () use ($svgContent) {
        echo $svgContent;
    }, 'qr-encuesta-panetto.svg');
})->name('survey.qr');

// Rutas de Google Auth
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

// Ruta para que el cliente desvincule su cuenta de Google y use otra
Route::post('/logout-public', function () {
    session()->forget('survey_google_user'); // Borra la sesión temporal en lugar de cerrar sesión de Auth
    return redirect()->route('survey.form');
})->name('logout.public');

Route::get('/', function () {
    return redirect()->route('admin.index');
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'The [public/storage] link has been connected';
});

require __DIR__ . '/settings.php';

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
