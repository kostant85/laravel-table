<?php

return [

	// Your table base namespace
	'namespace' => 'App\\Tables\\Builders',

	// Middleware for built in route
	'middleware' => ['web'],
	
	'lengthMenu' => [
		10, 15, 20, 25, 30,
	],

    /*
    |--------------------------------------------------------------------------
    | Labels used when the drawing a table
    |--------------------------------------------------------------------------
    |
    | The labels are translated if a localisation function is available
    |
     */
    'labels' => [
        'crtNo' => '#',
        'actions' => 'Actions',
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

    /*
    |--------------------------------------------------------------------------
    | Default Action Buttons
    |--------------------------------------------------------------------------
    | Here is a list of the default action buttons. You can edit any of the
    | defaults, or add/remove. Global buttons will be displayed above the
    | table while row buttons on each row. Row buttons will depend on
    | the dtRowId.
     */

    'buttons' => [
        'global' => [
            'create' => [
                'icon' => 'plus',
                'class' => null,
                'routeSuffix' => 'create',
                'event' => 'create',
                'action' => 'router',
                'label' => 'Create',
            ],
            'excel' => [
                'icon' => 'file-excel',
                'class' => null,
                'routeSuffix' => 'exportExcel',
                'event' => 'export-excel',
                'action' => 'export',
                'label' => 'Excel',
            ],
            'action' => [
                'icon' => 'check',
                'class' => null,
                'routeSuffix' => 'action',
                'event' => 'custom-action',
                'postEvent' => 'custom-action-done',
                'action' => 'ajax',
                'method' => 'PATCH',
                'label' => 'Action',
                'message' => 'Custom Action. Are you sure?',
                'confirmation' => true,
            ],
        ],
        'row' => [
            'show' => [
                'icon' => 'eye',
                'class' => 'is-row-button',
                'routeSuffix' => 'show',
                'event' => 'show',
                'action' => 'router',
            ],
            'edit' => [
                'icon' => 'pencil-alt',
                'class' => 'is-row-button',
                'routeSuffix' => 'edit',
                'event' => 'edit',
                'action' => 'router',
            ],
            'destroy' => [
                'icon' => 'trash-alt',
                'class' => 'is-row-button',
                'routeSuffix' => 'destroy',
                'event' => 'destroy',
                'action' => 'ajax',
                'method' => 'DELETE',
                'message' => 'The selected record is about to be deleted. Are you sure?',
                'confirmation' => true,
                'postEvent' => 'destroyed',
            ],
            'download' => [
                'icon' => 'cloud-download-alt',
                'class' => 'is-row-button',
                'routeSuffix' => 'download',
                'event' => 'download',
                'action' => 'href',
            ],
        ],
    ],

];