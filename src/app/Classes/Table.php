<?php

namespace Kostant\Table\Classes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kostant\Table\Classes\Table\Builder;
use Kostant\Table\Helpers\Obj;

abstract class Table
{
    protected $request;
    protected $templatePath = '';

    public function __construct(array $request = [])
    {
        $this->request = new Obj($request);
    }

    abstract public function query();

    public function init()
    {
        return (new Template($this->templatePath))
            ->get();
    }

    public function data()
    {
        return $this->transform($this->builder()->data());
    }

    public function excel()
    {
        return $this->builder()
            ->excel();
    }
	
	/**
	 * Transform the results
	 *
	 * @param Collection $items
	 *
	 * @return Collection
	 */
	public function transform(Collection $items): Collection
	{
		/*$entities = $items->get('data');
		
		return $items->put('data', $entities->map(function (Model $entity) {
			$columns = [];
			foreach (static::columns() as $column) {
				$columns[] = $entity->{$column};
			}
			
			return $columns;
		})->values());*/
		
		return $items;
	}
	
	/**
	 * @return array
	 */
	abstract public static function columns(): array;

    private function builder()
    {
        return (new Builder(
            $this->request,
            $this->query()
        ));
    }
}
