<?php


Route::group(['prefix'  =>  'admin'], function () {

    Route::get('login', 'App\Http\Controllers\Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'App\Http\Controllers\Admin\LoginController@login')->name('admin.login.post');
    Route::get('logout', 'App\Http\Controllers\Admin\LoginController@logout')->name('admin.logout');
    Route::group(['middleware' => ['auth:admin']], function () {

        Route::get('/', function () {
            return view('admin.dashboard.index');
        })->name('admin.dashboard');
        Route::get('/settings', 'App\Http\Controllers\Admin\SettingController@index')->name('admin.settings');
        Route::post('/settings', 'App\Http\Controllers\Admin\SettingController@update')->name('admin.settings.update');

        Route::group(['prefix'  =>   'categories'], function() {
            Route::get('/', 'App\Http\Controllers\Admin\CategoryController@index')->name('admin.categories.index');
            Route::get('/create', 'App\Http\Controllers\Admin\CategoryController@create')->name('admin.categories.create');
            Route::post('/store', 'App\Http\Controllers\Admin\CategoryController@store')->name('admin.categories.store');
            Route::get('/{id}/edit', 'App\Http\Controllers\Admin\CategoryController@edit')->name('admin.categories.edit');
            Route::post('/update', 'App\Http\Controllers\Admin\CategoryController@update')->name('admin.categories.update');
            Route::get('/{id}/delete', 'App\Http\Controllers\Admin\CategoryController@delete')->name('admin.categories.delete');
        });

        Route::group(['prefix'  =>   'courses'], function() {
            Route::get('/', 'App\Http\Controllers\Admin\CourseController@index')->name('admin.courses.index');
            Route::get('/create', 'App\Http\Controllers\Admin\CourseController@create')->name('admin.courses.create');
            Route::post('/store', 'App\Http\Controllers\Admin\CourseController@store')->name('admin.courses.store');
            Route::get('/{id}/edit', 'App\Http\Controllers\Admin\CourseController@edit')->name('admin.courses.edit');
            Route::post('/update', 'App\Http\Controllers\Admin\CourseController@update')->name('admin.courses.update');
            Route::get('/{id}/delete', 'App\Http\Controllers\Admin\CourseController@delete')->name('admin.courses.delete');
            Route::post('images/upload', 'App\Http\Controllers\Admin\CourseVideoController@upload')->name('admin.courses.videos.upload');
            Route::get('images/{id}/delete', 'App\Http\Controllers\Admin\CourseVideoController@delete')->name('admin.courses.videos.delete');
        });

        Route::group(['prefix' => 'videos'], function (){
            Route::get('/', 'App\Http\Controllers\Admin\VideoController@index')->name('admin.videos.index');
        });
    });

});
