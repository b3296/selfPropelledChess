<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-03-19
 * Time: 15:03
 */
Route::group([
    'prefix' => 'chess',
    'namespace' => 'SelfPropelledChess',
    'middleware' => ['auth'],
], function () {
    Route::resource('occupation', 'OccupationController');
    Route::get('occupation/{id}/show','OccupationController@show')->name('chess.occupation.show');
    Route::resource('race', 'RaceController');
    Route::get('race/{id}/show','RaceController@show')->name('chess.race.show');
    Route::resource('piece', 'PieceController');
    Route::get('piece/{id}/show','PieceController@show')->name('chess.piece.show');
});