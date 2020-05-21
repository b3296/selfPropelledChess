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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function () {
    Route::post('user/login','LoginController@login')->name('admin.user.login');
});

Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => ['auth'],
], function () {
    Route::resource('users', 'UserController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('roles', 'RoleController');

    Route::get('web_user/list','WebUserController@list')->name('admin.web_user.list');
    Route::get('web_user/{id}/edit','WebUserController@edit')->name('admin.web_user.edit');
    Route::put('web_user/update','WebUserController@update')->name('admin.web_user.update');

    Route::get('blog/list','BlogController@list')->name('admin.blog.list');
    Route::get('blog/{id}/show','BlogController@show')->name('admin.blog.show');
    Route::post('blog/update','BlogController@update')->name('admin.blog.update');

    Route::get('leave/list','LeaveController@list')->name('admin.leave.list');
    Route::get('leave/{id}/show','LeaveController@show')->name('admin.leave.show');
    Route::post('leave/update','LeaveController@update')->name('admin.leave.update');
});

Route::group([
    'prefix' => 'web',
    'namespace' => 'Web',
], function () {
    Route::get('login','WebUserController@login')->name('web.login');
    Route::get('register','WebUserController@register')->name('web.register');
    Route::post('registerDoit','WebUserController@registerDoit')->name('web.registerDoit');
    Route::post('loginDoit','WebUserController@loginDoit')->name('web.loginDoit');
    Route::any('logout','WebUserController@logout')->name('web.logout');


    Route::get('piece/index','ChessController@pieceIndex')->name('web.chess.piece.index');
    Route::get('piece/{id}/show','ChessController@pieceShow')->name('web.chess.piece.show');
    Route::get('occupation/index','ChessController@occupationIndex')->name('web.chess.occupation.index');
    Route::get('occupation/{id}/show','ChessController@occupationShow')->name('web.chess.occupation.show');
    Route::get('race/index','ChessController@raceIndex')->name('web.chess.race.index');
    Route::get('race/{id}/show','ChessController@raceShow')->name('web.chess.race.show');
    Route::post('piece/strategy','ChessController@strategy')->name('web.chess.piece.strategy');
    Route::get('strategy/list','ChessController@strategyList')->name('web.chess.strategy.list');
    Route::get('strategy/{id}/show','ChessController@strategyShow')->name('web.chess.strategy.show');

    Route::get('blog/list','BlogController@list')->name('web.blog.list');
    Route::get('blog/{id}/show','BlogController@show')->name('web.blog.show');

    Route::get('leave/list','LeaveController@list')->name('web.leave.list');
    Route::get('leave/{id}/show','LeaveController@show')->name('web.leave.show');
});

Route::group([
    'prefix' => 'web',
    'namespace' => 'Web',
    'middleware'=>'login'
], function () {

    Route::post('strategy/save','ChessController@strategySave')->name('web.chess.strategy.save');
    Route::post('praise/do','PraiseController@doPraise')->name('web.praise.do');

    Route::get('blog/create','BlogController@create')->name('web.blog.create');
    Route::post('blog/save','BlogController@save')->name('web.blog.save');

    Route::post('blog/comment','BlogController@comment')->name('web.blog.comment');

    Route::get('leave/create','LeaveController@create')->name('web.leave.create');
    Route::post('leave/save','LeaveController@save')->name('web.leave.save');
});






Route::any('test',function(){
  app('log.test')->info('yes');
});

require_once 'chess.php';
