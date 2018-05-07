<?php

namespace Kostant\Table\Classes\Table;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\QueryException;
use Kostant\Table\Helpers\Obj;

class Builder
{
	private $request;
	private $query;
	private $count;
	private $filtered;
	private $total;
	private $data;
	private $columns;
	private $meta;
	private $fullRecordInfo;
	
	public function __construct(Obj $request, QueryBuilder $query)
	{
		$this->request = $request;
		$this->meta = json_decode($this->request->get('meta'));
		$this->query = $query;
		$this->total = collect();
		
		$this->setColumns();
	}
	
	public function data()
	{
		$this->run();
		
		$this->checkActions();
		
		return collect([
			'count' => $this->count,
			'filtered' => $this->filtered,
			'total' => $this->total,
			'data' => $this->data,
			'fullRecordInfo' => $this->fullRecordInfo,
			'filters' => $this->hasFilters(),
		]);
	}
	
	public function excel()
	{
		$this->run();
		
		$export = new ExportComputor($this->data, $this->columns);
		
		return [
			'name' => $this->request->get('name'),
			'header' => $this->columns->pluck('label')->toArray(),
			'data' => $export->data()->toArray(),
		];
	}
	
	private function run()
	{
		$this->filtered = $this->count = $this->count();
		
		$this->setDetailedInfo()
			->filter()
			->sort()
			->setTotal()
			->limit()
//			->paginate()
			->setData()
			->setAppends()//			->toArray()
		;
	}
	
	private function checkActions()
	{
		if (count($this->data) === 0) {
			return;
		}
		
		/*if (!isset($this->data[0]['dtRowId'])) {
			throw new QueryException(__('You have to add in the main query \'id as "dtRowId"\' for the actions to work'));
		}*/
	}
	
	private function count()
	{
		return $this->query->count();
	}
	
	private function setDetailedInfo()
	{
		$this->fullRecordInfo = $this->hasFilters() && !optional($this->meta)->forceInfo
			? $this->count <= config('table.fullInfoRecordLimit')
			: true;
		
		return $this;
	}
	
	private function filter()
	{
		if ($this->hasFilters()) {
			(new Filters($this->request, $this->query, $this->columns))->set();
			
			if ($this->fullRecordInfo) {
				$this->filtered = $this->count();
			}
		}
		
		return $this;
	}
	
	private function sort()
	{
		if (!$this->meta->sort) {
			return $this;
		}
		
		$this->columns->each(function ($column) {
			if ($column->meta->sortable && $column->meta->sort) {
				$this->query->orderBy($column->data, $column->meta->sort);
			}
		});
		
		return $this;
	}
	
	private function setTotal()
	{
		if (!$this->meta->total || !$this->fullRecordInfo) {
			return $this;
		}
		
		$this->total = $this->columns->reduce(function ($total, $column) {
			if ($column->meta->total) {
				$total[$column->name] = $this->query->sum($column->data);
			}
			
			return $total;
		}, []);
		
		return $this;
	}
	
	private function limit()
	{
		$this->query->skip($this->meta->start)
			->take($this->meta->length);
		
		return $this;
	}
	
	
	private function setData()
	{
		$this->data = $this->query->get();
		
		return $this;
	}
	
	private function setAppends()
	{
		if (!$this->request->has('appends')) {
			return $this;
		}
		
		$this->data->each->setAppends($this->request->get('appends'));
		
		return $this;
	}
	
	private function toArray()
	{
		$this->data = $this->data->toArray();
		
		return $this;
	}
	
	
	private function setColumns()
	{
		$this->columns = collect($this->request->get('columns'))
			->map(function ($column) {
				return json_decode($column);
			});
	}
	
	private function hasFilters()
	{
		return $this->request->filled('search')
			|| $this->request->has('filters')
			|| $this->request->has('intervalFilters');
	}
}
