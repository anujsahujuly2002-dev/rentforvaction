<?php

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

Route::controller(HomeController::class)->name('frontend.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/destination', 'destination')->name('destination');
    Route::get('/contact-us', 'contact')->name('contact-us');
    Route::post('/contact-us', 'submitContact')->name('contact-us.submit');
    Route::get('/book-now', 'bookNow')->name('book-now');
    Route::get('/log-in', 'logIn')->name('log-in');
    Route::get('/register', 'register')->name('register');
    Route::get('/forgot', 'forgot')->name('forgot');
    Route::get('/recommended', 'recomended')->name('recommended');
    Route::get('/package', 'package')->name('package');
    Route::get('get-cordinate', 'getCordinates');
    Route::get('/property/ical-link/{id}', 'genratePropertIcalLink');
    Route::get('/search-destination', 'getSearchDestintaion');
    Route::get('privacy-policy', 'privacyPolicy')->name('privacy-policy');
    Route::get('terms-and-conditions', 'termsAndConditions')->name('terms-and-conditions');
    Route::get('/404', 'notFound')->name('not-found');
});

Route::controller(PropertyController::class)->group(function () {
    Route::get('/propeerty-list', 'index')->name('property.listing');
    Route::get('/property-details', 'propertyDetails')->name('property.details');
    Route::post('/property-inquiry', 'submitInquiry')->name('property.inquiry');
    Route::get('/check-property/{id}', 'checkProperty')->name('property.check');
});
