<?php

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

//Auth::routes();

Route::prefix('admin')->group(function () {
  // Auth Routes
  Auth::routes(['register' => false]);
  Route::get('/', function () {
      return redirect()->route('login');
  });
  Route::post('/admin-login', 'Auth\LoginController@adminLogin')->name('admin.login');
  
  Route::group(['middleware' => ['admin']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    // Edit Profile Routes
    Route::get('/edit-profile', 'HomeController@editProfile')->name('store.editProfile');
    Route::post('/edit-profile', 'HomeController@postEditProfile')->name('store.postEditProfile');

    Route::resources([
      'manage-frenchise' => 'Admin\FranchiseController',
      'manage-store' => 'Admin\StoreController',
      'manage-service' => 'Admin\ServiceController',
      'pickup-request' => 'Admin\PickupController'
    ]);
    
    Route::post('/store/status/{id}', 'Admin\StoreController@status')->name('manage-store.status');

    Route::post('/add-store/{id}', 'Admin\StoreController@saveSession')->name('admin.store.add');
    // Address Routes
    Route::get('/address', 'HomeController@addAddress')->name('admin.addAddress');
    Route::post('/address', 'HomeController@postAddAddress')->name('admin.postAddAddress');
    Route::get('/edit-address', 'HomeController@editAddress')->name('admin.editAddress');
    Route::post('/edit-address', 'HomeController@postEditAddress')->name('admin.postEditAddress');

    Route::get('/pin-details', 'HomeController@getPinDetails')->name('getPinDetails');

    // Rate Cards
    Route::get('/rate-card', 'Admin\RateCardController@getRateCard')->name('admin.getRateCard');
    Route::get('/rate-card-form', 'Admin\RateCardController@getRateCardForm')->name('admin.getRateCardForm');
    Route::post('/rate-card-form', 'Admin\RateCardController@postRateCardForm')->name('admin.postRateCardForm');

    Route::get('/services', 'HomeController@getServices')->name('admin.getServices');
    Route::post('/services', 'HomeController@getRate')->name('admin.getRate');
    Route::post('/find-store', 'Admin\PickupController@findCustomer')->name('admin.findCustomer');
    
    Route::post('/logout', 'Auth\LoginController@logout')->name('admin.logout');

  });
});


Route::prefix('store')->group(function () {

  Route::group(['middleware' => ['web', 'checkPrefix']], function () {
      Route::get('/', function () {
          return redirect()->route('store.login');
      });
      Route::get('/login', 'Store\LoginController@getLogin')->name('store.login');
      Route::post('/login', 'Store\LoginController@postLogin')->name('store.login');


     Route::group(['middleware' => ['store']], function () {
         Route::get('/home', 'Store\HomeController@index')->name('store.home');

         Route::get('/customer-details/{id}', 'Store\HomeController@getcustomerdetails')->name('getcustomerdetails');
         Route::get('/address-details/{id}', 'Store\HomeController@getaddressdetails')->name('getaddressdetails');
      });
      Route::post('/notifications/read-all', 'Store\NotificationsController@markRead')->name('notifications.mark-read');
    
  //   Route::get('/home', 'HomeController@index')->name('home');
  //   Route::get('/dashboard', 'HomeController@index')->name('dashboard');
  //   // Edit Profile Routes
  //   Route::get('/edit-profile', 'HomeController@editProfile')->name('store.editProfile');
  //   Route::post('/edit-profile', 'HomeController@postEditProfile')->name('store.postEditProfile');

  //   Route::resources([
  //     'manage-frenchise' => 'Admin\FranchiseController',
  //     'manage-store' => 'Admin\StoreController',
  //     'manage-service' => 'Admin\ServiceController',
  //     'pickup-request' => 'Admin\PickupController'
  //   ]);
    
  //   Route::post('/store/status/{id}', 'Admin\StoreController@status')->name('manage-store.status');

  //   Route::post('/add-store/{id}', 'Admin\StoreController@saveSession')->name('admin.store.add');
  //   // Address Routes
  //   Route::get('/address', 'HomeController@addAddress')->name('admin.addAddress');
  //   Route::post('/address', 'HomeController@postAddAddress')->name('admin.postAddAddress');
  //   Route::get('/edit-address', 'HomeController@editAddress')->name('admin.editAddress');
  //   Route::post('/edit-address', 'HomeController@postEditAddress')->name('admin.postEditAddress');

  //   Route::get('/pin-details', 'HomeController@getPinDetails')->name('getPinDetails');

  //   // Rate Cards
  //   Route::get('/rate-card', 'Admin\RateCardController@getRateCard')->name('admin.getRateCard');
  //   Route::get('/rate-card-form', 'Admin\RateCardController@getRateCardForm')->name('admin.getRateCardForm');
  //   Route::post('/rate-card-form', 'Admin\RateCardController@postRateCardForm')->name('admin.postRateCardForm');

  //   Route::get('/services', 'HomeController@getServices')->name('admin.getServices');
  //   Route::post('/services', 'HomeController@getRate')->name('admin.getRate');
  //   Route::post('/find-store', 'Admin\PickupController@findCustomer')->name('admin.findCustomer');
    
    Route::post('/logout', 'Store\LoginController@logout')->name('store.logout');

  });
});
