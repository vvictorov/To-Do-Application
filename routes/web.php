<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/', function () {

    if(Auth::check())
    {
        return redirect('/lists');
    }
    else
    {
        return redirect('/login');
    }
});

Route::get('/lists', 'ListsController@index');
Route::get('/newlist' , 'ListsController@newlist');
Route::get('/archive', 'ListsController@archives_view');
Route::post('/addlist' , 'ListsController@addlist');
Route::delete('/deleteList/{id}' , 'ListsController@delete');
Route::patch('/archiveList/{id}' , 'ListsController@archive');
Route::put('/addTask/{list_id}' , 'TasksController@addTask');
Route::delete('/deleteTask/{id}' , 'TasksController@delete');
Route::post('/taskChangeStatus/{id}' , 'TasksController@changeStatus');
Route::get('/admin' , 'PagesController@admin');
