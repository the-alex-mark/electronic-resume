<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\TestController;
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

    Route::middleware([ 'checking' ])->group(function () {

        // Раздел "Тест"
        Route::prefix('test')->group(function () {
            Route::get('{test}', [ TestController::class, 'create' ])->name('test.show');
            Route::get('edit', [ TestController::class, 'create' ])->name('test.create');
            Route::get('{test}/edit', [ TestController::class, 'edit' ])->name('test.edit');
            Route::any('{test}/export', [ TestController::class, 'export' ])->name('test.export');
            Route::any('{test}/delete', [ TestController::class, 'delete' ])->name('test.delete');
            Route::post('save', [ TestController::class, 'save' ])->name('test.save');

            // Вспомогательные маршруты
            Route::post('question', [ TestController::class, 'question' ])->name('test.question');
            Route::post('answer', [ TestController::class, 'answer' ])->name('test.answer');
        });
    });
});
