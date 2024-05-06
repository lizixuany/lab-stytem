<?php
use think\facade\Route;

Route::get('news','NewsController@index');
Route::get('news/:id','NewsController@detail');