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

//Admin routes
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'role:admin']], function () {
    Route::resource('team', 'TeamController');
    Route::post('team/{team}/status-update', 'TeamController@statusUpdate')->name('team.status-update');
    Route::post('team/{team}/add-members', 'TeamController@addMembers')->name('team.add-members');
    Route::delete('team/{team}/remove-member', 'TeamController@removeMember')->name('team.remove-member');
});