<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::get('/api/agents', 'AgentController@search');
Route::get('/api/logout', 'LoginController@logout');
Route::get('/api/articles', 'ArticleController@search');

Route::resource('/api/demande', 'DemandeController');
Route::resource('/api/retourn', 'ReteurnController');
Route::get('/pdf-demande/{id}', 'DemandeController@PDFDemande');

Route::get('/{any?}', function (){
    return view('welcome');
})->where('any', '[\/\w\.-]*');

