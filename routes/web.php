<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SummaryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.welcome');
});

Auth::routes();

Route::middleware([ 'auth' ])->group(function () {

    Route::middleware([ 'candidate' ])->group(function () {
        Route::get('home', [ HomeController::class, 'index' ])->name('home');

        // Раздел "Анкета"
        Route::prefix('summary')->group(function () {
            Route::get('{summary}', [ SummaryController::class, 'create' ])->name('summary.show');
            Route::get('edit', [ SummaryController::class, 'create' ])->name('summary.create');
            Route::get('{summary}/read', [ SummaryController::class, 'read' ])->name('summary.read');
            Route::get('{summary}/edit', [ SummaryController::class, 'edit' ])->name('summary.edit');
            Route::post('save', [ SummaryController::class, 'save' ])->name('summary.save');

            // Вспомогательные маршруты
            Route::post('place/{type}', [ SummaryController::class, 'place' ])->name('summary.place')->where([ 'type' => '(education)|(experience)' ]);
        });
    });
});
