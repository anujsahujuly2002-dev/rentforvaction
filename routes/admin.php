<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->name('admin.')->group(function() {

    // Authanitication Route
    Route::namespace('Auth')->middleware(['guest'])->controller(AuthController::class)->group(function(){
        Route::get('/','login')->name('login');
        Route::post('/login','doLogin')->name('do.login');
        Route::get('/forget-password','forgetPassword')->name('forget.password');
        Route::post('/forget-password-send-link','sendForgetPasswordLink')->name('send.forget.password.link');
        Route::get('reset-password/{token}','resetPassword')->name('reset.password.get');
        Route::post('/password-reset','passwordReset')->name('password.reset');
    });

    // After Authanitication Routes
    Route::middleware(['auth'])->group(function() {
        Route::controller(DashboardController::class)->group(function(){
            Route::get('/dashboard','index')->name('dashboard');
            Route::get('/logout','logout')->name('logout');
        });

        // Permmission Route
        Route::controller(PermissionController::class)->name('permission.')->prefix('permission')->group(function(){
            Route::get("/","index")->name('list');
            Route::get("/create","create")->name('create');
            Route::post("/store","store")->name('store');
            Route::get("/edit/{id}","edit")->name('edit');
            Route::post("/update","update")->name('update');
            Route::post("/delete","delete")->name('delete');
        });

        // Role Route
        Route::controller(RoleController::class)->name('role.')->prefix('role')->group(function(){
            Route::get("/","index")->name('list');
            Route::get("/create","create")->name('create');
            Route::post("/store","store")->name('store');
            Route::get("/edit/{id}","edit")->name('edit');
            Route::post("/update","update")->name('update');
            Route::post("/delete","delete")->name('delete');
        });

        // Staff Management Route
        Route::controller(StaffController::class)->prefix('staff')->name('staff.')->group(function(){
            Route::get('/','index')->name('list');
            Route::get('/create','create')->name('create');
            Route::post('/store','store')->name('store');
            Route::get('/edit/{id}','edit')->name('edit');
            Route::post('/update','update')->name('update');
            Route::post('/delete','delete')->name('delete');
        });

        // Destination management Routes

        Route::controller(DestinationController::class)->prefix('destination')->name('destination.')->group(function(){
            Route::get('/country','countryList')->name('country.index');
            Route::get('/country/create','countryCreate')->name('country.create');
            Route::post('/country/store','countryStore')->name('country.store');
            Route::get('/country/edit/{id}','countryEdit')->name('country.edit');
            Route::post('/country/update','countryUpdate')->name('country.update');
            Route::post('/country/delete','countryDelete')->name('country.delete');

            // State Route
            Route::get('/state','stateList')->name('state.index');
            Route::get('/state/create','stateCreate')->name('state.create');
            Route::post('/state/store','stateStore')->name('state.store');
            Route::get('/state/edit/{id}','stateEdit')->name('state.edit');
            Route::post('/state/update','stateUpdate')->name('state.update');
            Route::post('/state/delete','stateDelete')->name('state.delete');
            Route::post('/get-state-by-country-id','getStateByCountryId');

            // Region Route
            Route::get('/region','regionList')->name('region.index');
            Route::get('/region/create','regionCreate')->name('region.create');
            Route::post('/region/store','regionStore')->name('region.store');
            Route::get('/region/edit/{id}','regionEdit')->name('region.edit');
            Route::post('/region/update','regionUpdate')->name('region.update');
            Route::post('/region/delete','regionDelete')->name('region.delete');
            Route::post('/get-region-by-state-id','getRegionByStateId');

            // City Route
            Route::get('/city','cityList')->name('city.index');
            Route::get('/city/create','cityCreate')->name('city.create');
            Route::post('/city/store','cityStore')->name('city.store');
            Route::get('/city/edit/{id}','cityEdit')->name('city.edit');
            Route::post('/city/update','cityUpdate')->name('city.update');
            Route::post('/city/delete','cityDelete')->name('city.delete');
            Route::post('/get-city-by-region-id','getCityByRegionId');


            //Sub City Route
            Route::get('/subcity','subcityList')->name('subcity.index');
            Route::get('/subcity/create','subcityCreate')->name('subcity.create');
            Route::post('/subcity/store','subcityStore')->name('subcity.store');
            Route::get('/subcity/edit/{id}','subcityEdit')->name('subcity.edit');
            Route::post('/subcity/update','subcityUpdate')->name('subcity.update');
            Route::post('/subcity/delete','subcityDelete')->name('subcity.delete');
            Route::post('/get-sub-city-by-city-id','getSubCityById');

        });

        Route::controller(PropertyController::class)->prefix('property')->name('property.')->group(function () {
            Route::get('/','index')->name('index');
            Route::get('/create/{id?}','create')->name('create');
            Route::get('/get-property-rates','getPropertyRates');
            Route::post('/check-aminites-description','checkAminitesDescription');
            Route::post('/property-information','propertyInformation');
            Route::post('/aminites-store','amenitesStore');
            Route::post('/location-store','locationStore');
            Route::post('/rates-store','ratesStore');
            Route::post('/rental-rates-store','rentalRatesStore');
            Route::post('/gallery-image-store','galleryImageStore');
            Route::post('/rental-polices-store','rentalPolicesStore');
            Route::post('/calender-synchronization','calenderSyncronization');
            Route::get('/get-property-bookings','getPropertyBookings');
            Route::post('/manual-booking-store','manualBookingStore');
            Route::post('/delete-booking','deleteBooking');
            Route::post('/reviews-store','reviewStore');
            Route::get('/get-property-reviews','getPropertyReviews');
            Route::post("/owner-information-store","owmerInformationStore");
            Route::post("/get-rental-rates-by-id","getRentalRatesById");
            Route::post("/rentals-rates-update","rentalRatesUpdate");
            Route::post("delete-rental-rates","deleteRentalRates");
            Route::post("edit-property-reviews","editPropertyReviews");
            Route::post('/review-rating-update',"reviewsRatingUpdate");
            Route::post('/delete-reviews-rating',"deleteReviewsRating");
            Route::post('/add-featured-property','addFeaturedProperty');
            Route::post('/add-recommendation','addRecommendation');
            Route::post('/property-approved','propertyApproved');
            Route::post('/delete-property','deleteProperty');
        });

        Route::controller(OwnerController::class)->prefix('owner')->name('owner.')->group(function() {
            Route::get('/','index')->name('index');
        });

    });

});

