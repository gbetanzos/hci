<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('monitors',[App\Http\Controllers\MonitorController::class, 'store'])->name('monitors.store');
Route::delete('monitors',[App\Http\Controllers\MonitorController::class, 'destroy'])->name('monitors.destroy');
Route::match(['get', 'post'], 'botman', [App\Http\Controllers\BotManController::class, 'handle']);