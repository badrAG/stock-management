<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/admin','Auth\RegisterController' );
Route::apiResource('/admin/e/','Auth\RegisterController@modifier');
Route::apiResource('/admins','API\AdminController');
Route::get('/admin/profile', 'API\AdminController@profile');
Route::apiResource('/article','ArticleController' );
Route::apiResource('/fournisseur','FournisseurController' );
Route::apiResource('/dashboard','DashboardController' );
Route::apiResource('/agent','AgentController' );
Route::apiResource('/category','CategoryController' );
Route::apiResource('/reteurn','ReteurnController' );
Route::apiResource('/service','ServiceController');
Route::apiResource('/modeles','ModeleController' );
Route::apiResource('/marques','MarqueController' );