<?php

namespace Kostant\Table\Core;

use Illuminate\Http\Request;
use Kostant\Table\Classes\Table;

class Factory
{
	/**
	 * @param string $grid
	 *
	 * @return Table
	 */
	public static function make(string $grid, $request = []): Table
	{
		$pieces = explode('.', $grid);
		$grid = implode('\\', array_map('studly_case', $pieces));

		$gridClass = config('table.namespace') . "\\{$grid}";

		abort_unless(class_exists($gridClass), 404);

		return new $gridClass($request);
	}
}