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

Route::get('/', 'RecordController@index');
Route::get('/get_info', 'RecordController@get_info');

Route::get('/register_new', 'RecordController@register_new_page');
Route::post('/register_new', 'RecordController@register_new');

Route::get('/recharge_card', 'RecordController@recharge_card_page');
Route::post('/recharge_card', 'RecordController@recharge_card');

Route::post('/get_card_info', 'RecordController@get_card_info');

Route::post('/get_info', 'RecordController@get_info');
Route::post('/ajax_command', 'RecordController@ajaxCommand');
Route::post('/cabinet_manager', 'RecordController@cabinetManager');

Route::post('/cabinet_info', 'RecordController@get_cabinet_info');
// Route::get('/cabinet_manager', 'RecordController@cabinetManager'); 


/* This two routes manages cabinet status and management in admin menu */
Route::get('/info/cabinet/{cabinet_id}', 'RecordController@cabinet_status');
Route::post('/action/cabinet/{id}/empty', 'RecordController@cabinet_empty');
Route::post('/action/cabinet/{id}/open', 'RecordController@cabinet_open');


Route::get('/manage/users', 'RecordController@manage_users');
Route::post('/users/{id}/page', 'RecordController@get_users_list');

