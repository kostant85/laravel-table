<?php

return [

	// Your table base namespace
	'namespace' => 'App\\Tables\\Builders',

	// Middleware for built in route
	'middleware' => ['web'],
	
	'lengthMenu' => [
		1, 10, 15, 20, 25, 30,
	],
	
	/*
	|--------------------------------------------------------------------------
	| Date format
	|--------------------------------------------------------------------------
	| Global date format for date columns. Will use Carbon to parse the columns
	| marked as date to the desired format.
	|
	*/
	
	'dateFormat' => 'd-m-Y',
	
	/*
	|--------------------------------------------------------------------------
	| Detailed information record limit
	|--------------------------------------------------------------------------
	| Sometimes the table handles hundreds of millions of records. By setting
	| an upper limit for detailed information the permformance can be
	| greatly improved. The info can still be called on demand.
	*/
	
	'fullInfoRecordLimit' => 100000,
	
	/*
	|--------------------------------------------------------------------------
	| Debounce Rate
	|--------------------------------------------------------------------------
	|
	| Configure the debounce for the serverside requests. Use a higher value for
	| a bigger table.
	*/
	
	'debounce' => 100,

];