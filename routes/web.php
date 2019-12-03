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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{token}/{data}', 'Controller@download');
Route::post('/generate', 'HomeController@generate')->name('generate');

Route::get('test','Controller@responseDownload');


// <IfModule mod_rewrite.c>
//     <IfModule mod_negotiation.c>
//         Options -MultiViews -Indexes
//     </IfModule>

//     RewriteEngine On

//     # Handle Authorization Header
//     RewriteCond %{HTTP:Authorization} .
//     RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

//     # Redirect Trailing Slashes If Not A Folder...
//     RewriteCond %{REQUEST_FILENAME} !-d
//     RewriteCond %{REQUEST_URI} (.+)/$
//     RewriteRule ^ %1 [L,R=301]

//     # Handle Front Controller...
//     RewriteCond %{REQUEST_FILENAME} !-d
//     RewriteCond %{REQUEST_FILENAME} !-f
//     RewriteRule ^ index.php [L]
// </IfModule>
