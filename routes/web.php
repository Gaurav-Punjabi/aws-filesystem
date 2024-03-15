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

Route::get("/", "App\\Http\\Controllers\\MainController@showPath")->name("show-path");
Route::get("/file/{id}", "App\\Http\\Controllers\\MainController@openFile")->name("open-file");
Route::post("/upload", "App\\Http\\Controllers\\MainController@uploadFile")->name("upload-file");
Route::get("/search", "App\\Http\\Controllers\\MainController@search")->name("search");
Route::get("remove/{id}", "App\\Http\\Controllers\\MainController@remove")->name("remove");
Route::post("/folder", "App\\Http\\Controllers\\MainController@createFolder")->name("create-folder");
