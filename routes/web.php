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
// Admin Part
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        // Amin routes
        Route::resource('admin', 'Admin\AdminController');
        Route::resource('roles', 'Admin\RoleController');
//        Route::resource('categories', 'Admin\CategoryController');
        Route::resource('users', 'Admin\UserController');
        Route::resource('settings', 'Admin\SettingController');
        Route::resource('exchanges', 'Admin\ExchangeController');
        Route::resource('signals', 'Admin\SignalController');
    });
    // Default
    Route::get('/home', 'HomeController@index')->name('home');
});

Route::get('test', function () {
    $signal = \App\Models\Signal::find(1);
//    return $signal;
    return  new \App\Http\Resources\SignalResource($signal);
    event(new \App\Events\SignalSent($signal));
    return "Event has been sent!";
});
