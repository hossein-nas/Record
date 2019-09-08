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




/*

Route::get('/', function () {
	
	if (request()->has('komod') ){
		$komod = request()->get('komod');
		$host    = "127.0.0.1";
		$port    = 1234;
		$message = "ready?". "\n";
		// create socket
		$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
		// connect to server
		$result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
		// send string to server
		socket_write($socket, $message, strlen($message)) or die("Could not send data to server\n");
		// get server response
		$result = socket_read ($socket, 1024) or die("Could not read server response\n");
		if ( trim($result) == 'ready'){
			$message = "komod".$komod;
			echo $message;
			socket_write($socket,$message,strlen($message) );
		}
			echo "Hooraa";
		// close socket
		socket_close($socket);
	}
	return view('index');
});

*/