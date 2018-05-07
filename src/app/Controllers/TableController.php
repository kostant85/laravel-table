<?php

namespace Kostant\Table\Controllers;

use Kostant\Table\Core\Factory;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class TableController extends Controller
{
	public function init(string $grid)
	{
		return (Factory::make($grid))
			->init();
	}
	
	public function data(Request $request, string $grid)
	{
		return (Factory::make($grid, $request->all()))
			->data();
	}
}
