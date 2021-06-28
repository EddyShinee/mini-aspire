<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyJWTToken;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(
    [
        'namespace' => 'Api',
        'prefix' => 'user',
        'middleware' => VerifyJWTToken::class
    ], function () {

    Route::get('logout', ['uses' => 'UserController@logout']);
    Route::get('profile', ['uses' => 'UserController@getProfile']);

});

Route::group(
    [
        'namespace' => 'Api',
        'prefix' => 'user',
    ], function () {

    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@register');

});
