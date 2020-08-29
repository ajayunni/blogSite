<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('post', array('uses' => 'CommentsController@store'));
Route::post('posts/{id}', array('uses' => 'LikesController@store'));
Route::put('/posts/comments/{id}/edit', array('uses' => 'CommentsController@update'));
Route::get('/posts/comments/{id}/edit','CommentsController@edit');
Route::delete('post/{id}', array('uses' => 'CommentsController@destroy'));
Route::get('posts/{post_id}/comments/{comment_id}/reply', array('uses' => 'CommentsController@create'));
Route::post('posts/{post_id}/comments/{comment_id}/reply', array('uses' => 'CommentsController@create'));
Route::resource('posts','PostsController');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
