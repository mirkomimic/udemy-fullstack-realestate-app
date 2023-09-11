<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [IndexController::class, 'index']);
Route::get('/hello', [IndexController::class, 'show'])
  ->middleware('auth');

Route::resource('listing', ListingController::class)
  ->only(['index', 'show']);
  // ->only(['index', 'show', 'create', 'store']);
  // ->except(['destroy']);

Route::get('login', [AuthController::class, 'create'])->middleware('guest:web')->name('login');
Route::post('login', [AuthController::class, 'store'])->middleware('guest:web')->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

Route::resource('user-account', UserAccountController::class)->only(['create', 'store'])->middleware('guest:web');

// Route::put('reltor/listing/{listing}/restore', [RealtorListingController::class, 'restore'])->name('realtor.listing.restore');

Route::prefix('realtor')->name('realtor.')->middleware('auth')->group(function() {
  Route::put('listing/{listing}/restore', [RealtorListingController::class, 'restore'])->name('listing.restore')->withTrashed();
  Route::resource('listing', RealtorListingController::class)
    ->only(['index', 'destroy', 'edit', 'update', 'create', 'store'])
    ->withTrashed();
});