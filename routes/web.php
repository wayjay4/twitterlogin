<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwitterController;
use App\Http\Controllers\FacebookController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// twitter routes

Route::get('auth/twitter', [TwitterController::class, 'loginwithTwitter']);

Route::get('auth/callback/twitter', [TwitterController::class, 'cbTwitter']);

Route::get('terms_of_service', [TwitterController::class, 'tosTwitter']);

Route::get('privacy_policy', [TwitterController::class, 'ppTwitter']);

// facebook routes

Route::get('auth/facebook', [FacebookController::class, 'loginwithFacebook']);

Route::get('auth/callback/facebook', [FacebookController::class, 'cbFacebook']);

Route::get('terms_of_service', [FacebookController::class, 'tosFacebook']);

Route::get('privacy_policy', [FacebookController::class, 'ppFacebook']);

