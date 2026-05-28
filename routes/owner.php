<?php

use Illuminate\Support\Facades\Route;

Route::prefix('owner')->name('owner.')->group(function(){
    Route::controller(AuthController::class)->group(function() {
        Route::get('register','register')->name('register');
        Route::post('register-store','registerStore');
        Route::group(['middleware' => ['guest']], function(){

            Route::get('login','login')->name('login');
        });

        Route::post('check-login','checkLogin');
    });
    Route::group(['middleware'=>['auth:web']],function(){
        Route::controller(HomeController::class)->group(function() {
            Route::get('/dashboard','dashboard')->name('dashboard');
            Route::get('/my-profile','myProfile')->name('myprofile');

            Route::get('/inquiries','inquiries')->name('inquiries');
            Route::post('/edit-profile','editProfile');
            Route::get('/logout','logOut')->name('logout');
            Route::post('/profile-photo','profilePhoto');
            Route::post('/owner-address','ownerAddress');
            Route::post('/change-password','changePassword');
        });
        Route::controller(PropertyController::class)->prefix('property')->name('property.')->group(function(){
            Route::get('/','create')->name('create');
            Route::post('/store-property-information','storePropertyInformation');
            Route::get('/amienites','amienites')->name('amenities');
            Route::post('aminites-properties','aminitiesStore');
            Route::get('location','location')->name('location');
            Route::post('/location-store','locationStore');
            Route::get('/rental-rates','rentalRates')->name('rental.rates');
            Route::get('/get-property-rates','getPropertyRates');
            Route::post('/rental-rates-store','rentalRatesStore');
            Route::post('add-more-rental-rates','addMoreRentalRates');
            Route::get('/property-gallery-image','propertyGalleryImage')->name('gallery.image');
            Route::post('/gallery-image-store','galleryImageStore');
            Route::post('/delete-gallery-image','deleteGalleryImage');
            Route::get('/rental-policies','rentalPolicies')->name('rental.policies');
            Route::post('/rental-polices-store','rentalPoliciesStore');
            Route::get('/calender','calender')->name('calender');
            Route::post('/calender-syncronization','calenderSyncronization');
            Route::get('/get-property-bookings','getPropertyBookings');
            Route::post('/manual-booking-store','manualBookingStore');
            Route::post('/delete-booking','deleteBooking');
            Route::get('/reviews','reviews')->name('reviews');
            Route::get('/get-reviews','getPropertyReviews')->name('get.reviews');
            Route::post('/reviews-store','reviewsStore');
            Route::post('/delete-reviews','deleteReviews');
            Route::post('/delete-property-rates','deletePropertyRates');
            Route::post('/edit-rental-rates','editRentalRates');
            Route::post('/update-rental-rates','updateRentalRates');
            Route::post('/edit-property-reviews','editPropertyRevies');
            Route::post('/update-property-reviews','updatePropertyRevies');
            Route::get('/enquiry','enquiry')->name('enquiry');
            Route::post('/submit-enquiry','submitEnquiry');
        });
    });

});
