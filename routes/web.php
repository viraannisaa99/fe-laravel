<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

// Route::get('/', function () {
//     return redirectToProtectedRoute();
// });

Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'prosesLogin'])->name('auth.loginproses');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::resource('posts', PostController::class);

Route::get('/', function () {
    $response = Http::withToken(Cookie::get('token'))
        ->get(env('API_BACKEND') . '/api/user-profile');

    if ($response->ok()) {
        return redirect()->route('posts.index');
    } else {
        return view('login');
    }
});
