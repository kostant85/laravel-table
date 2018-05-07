<?php

Route::get('/data-table/{table}/init', '\\Kostant\\Table\\Controllers\\TableController@init')
	->middleware(config('table.middleware'))
	->name('data_table.init');

Route::get('/data-table/{table}/data', '\\Kostant\\Table\\Controllers\\TableController@data')
	->middleware(config('table.middleware'))
	->name('data_table.data');