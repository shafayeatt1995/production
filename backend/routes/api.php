<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'api', 'namespace' => 'App\Http\Controllers\Api'], function () {

    // Frontend API
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('user', 'AuthController@user');

    //User Controller
    Route::get('all-user', 'UserController@allUser');
    Route::get('role-list', 'UserController@roleList');
    Route::post('status-user/{id}', 'UserController@statusUser');
    Route::post('search-user', 'UserController@searchUser');
    Route::post('create-user', 'UserController@createUser');
    Route::get('edit-user/{id}', 'UserController@editUser');
    Route::post('update-user/{id}', 'UserController@updatUser');


    //Buyer Controller
    Route::get('buyer', 'BuyerController@index');
    Route::get('edit-buyer/{id}', 'BuyerController@editBuyer');
    Route::get('list-buyer/{id}', 'BuyerController@listBuyer');
    Route::post('create-buyer', 'BuyerController@createBuyer');
    Route::post('update-buyer/{id}', 'BuyerController@updateBuyer');
    Route::post('delete-buyer', 'BuyerController@deleteBuyer');
    Route::post('search-buyer', 'BuyerController@searchBuyer');

    // //Category Controller
    // Route::get('category', 'CategoryController@index');
    // Route::get('category-list', 'CategoryController@categoryList');
    // Route::get('edit-category/{id}', 'CategoryController@editCategory');
    // Route::post('create-category', 'CategoryController@createCategory');
    // Route::post('update-category/{id}', 'CategoryController@updateCategory');
    // Route::post('delete-category', 'CategoryController@deleteCategory');
    // Route::post('search-category', 'CategoryController@searchCategory');
    // Route::post('status-category/{id}', 'CategoryController@statusCategory');

});

Route::group(['namespace' => 'App\Http\Controllers\Api'], function () {
    Route::get('app', 'AppController@app');
});
