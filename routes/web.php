<?php
Route::view('/', 'welcome')->name('home');

Route::get('statuses', 'StatusesController@index')->name('statuses.index');
Route::post('statuses', 'StatusesController@store')
    ->name('statuses.store')
    ->middleware('auth');

Route::post('statuses/{status}/likes', 'StatusLikesController@store')
    ->name('statuses.likes.store')
    ->middleware('auth');

Route::delete('statuses/{status}/likes', 'StatusLikesController@destroy')
    ->name('statuses.likes.destroy')
    ->middleware('auth');

Route::post('statuses/{status}/comments', 'StatusCommentsController@store')
    ->name('statuses.comments.store')
    ->middleware('auth');

Route::post('comments/{comment}/likes', 'CommentLikesController@store')
    ->name('comments.likes.store')
    ->middleware('auth');
Route::delete('comments/{comment}/likes', 'CommentLikesController@destroy')
    ->name('comments.likes.destroy')
    ->middleware('auth');

Route::get('@{user}', 'UsersController@show')->name('users.show');

Route::auth();
