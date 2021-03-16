<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', 'Controller@index') -> name ('index');

Route::get('/home', 'HomeController@index')
          ->name('home');
Route::get('/restaurant/{id}', 'Controller@restaurantShow')
          -> name('restaurant-show');


//rotta dashboard autenticata
Route::get('/restaurant', 'DashboardController@dashboard') -> name('dashboard');


//rotte dashboard
Route::get('/restaurant/info/edit', 'HomeController@restaurantEdit')
          -> name('restaurant-edit');
Route::post('/restaurant/info/upload', 'HomeController@uploadInfo')
          -> name('upload-info');
Route::get('/restaurant/photo/delete', 'HomeController@deleteIcon')
          -> name('delete-icon');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/restaurant/info/stats', 'DashboardController@stats')
        -> name('stats');
Route::get('/restaurant/info/feedbacks', 'DashboardController@feedbackPage') 
        -> name('feedbacks');


//Rotte plate
Route::get('/rest/plates', 'PlateController@platesIndex')
          -> name('plates-index');
Route::get('/restaurant/plates/new-plate', 'PlateController@platesCreate')
          -> name('plates-create');
Route::post('restaurant/plates/store-plate', 'PlateController@plateStore')
          -> name('plates-store');
Route::get('/restaurant/plates/edit/{id}', 'PlateController@platesEdit')
          -> name ('plates-edit');
Route::post('/restaurant/plates/edit/update/{id}', 'PlateController@platesUpdate')
          -> name ('plates-update');
Route::get('/restaurant/plates/delete/img/{id}', 'PlateController@deleteImg')
          -> name('plate-delete-img');
Route::get('/restaurant/plates/remove/{id}', 'PlateController@deletePlate')
          -> name('delete-plate');



//Rotte definitive API ricerca
Route::get('getallrestaurants', 'ResearchController@getAllRestaurants') -> name('get-all-restaurants');
Route::get('getrestaurantsinit', 'ResearchController@getRestaurantsInit') -> name('get-restaurants-init');
Route::get('search/{query}', 'ResearchController@searchTypsRestsPlats') -> name('search-typs-rests-plats');
Route::get('getallrestbyname/{query}', 'ResearchController@searchRestNamesAll') -> name('get-all-rest-by-name');
Route::get('getallplatebyname/{query}', 'ResearchController@searchPlateNamesAll') -> name('get-all-plate-by-name');

//Dashboard -> visualizza ordini
Route::get('/dashboard/restaurant/orders', 'OrderController@restaurantOrder') -> name('restaurant-order');
Route::get('/dashboard/restaurant/comanda/{id}', 'OrderController@restaurantComanda') -> name('restaurant-comanda');


  // carrello + ordine effettuato
Route::post('/keep-cart', 'PaymentController@getCart')
        -> name('get-cart');
Route::post('/new/order/store', 'PaymentController@storeOrder')
        -> name('order-store');
Route::post('/checkout/{id}', 'PaymentController@checkout')
        -> name('checkout');
Route::get('/fail', 'PaymentController@fail')
        -> name('fail');
