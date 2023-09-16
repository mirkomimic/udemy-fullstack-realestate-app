<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationSeenController;
use App\Http\Controllers\RealtorListingAcceptOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
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

Route::resource('listing.offer', ListingOfferController::class)->middleware('auth')->only(['store']);

Route::resource('notification', NotificationController::class)->middleware('auth')->only(['index']);

Route::put('notification/{notification}/seen', NotificationSeenController::class)->middleware('auth')->name('notification.seen');

Route::get('login', [AuthController::class, 'create'])->middleware('guest:web')->name('login');
Route::post('login', [AuthController::class, 'store'])->middleware('guest:web')->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');

Route::resource('user-account', UserAccountController::class)->only(['create', 'store'])->middleware('guest:web');

// Route::put('reltor/listing/{listing}/restore', [RealtorListingController::class, 'restore'])->name('realtor.listing.restore');

Route::prefix('realtor')->name('realtor.')->middleware('auth')->group(function () {
  Route::put('listing/{listing}/restore', [RealtorListingController::class, 'restore'])->name('listing.restore')->withTrashed();
  Route::resource('listing', RealtorListingController::class)->withTrashed();

  Route::put('offer/{offer}/accept', RealtorListingAcceptOfferController::class)->name('offer.accept');

  Route::resource('listing.image', RealtorListingImageController::class)
    ->only(['create', 'store', 'destroy']);
});
