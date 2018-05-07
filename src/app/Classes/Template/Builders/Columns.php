<?php

namespace Kostant\Table\Classes\Template\Builders;

use Kostant\Table\Classes\Attributes\Meta as Attributes;

class Columns
{
    private $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function build()
    {
        $this->template->columns = collect($this->template->columns)
            ->reduce(function ($columns, $column) {
                if (property_exists($column, 'meta')) {
                    $this->computeMeta($column);
                }

                if (property_exists($column, 'enum')) {
                    $this->template->enum = true;
                }

                if (property_exists($column, 'money')) {
                    $this->template->money = true;
                }

                $columns->push($column);

                return $columns;
            }, collect());
    }

    private function computeMeta($column)
    {
        $column->meta = collect(Attributes::List)->reduce(function ($meta, $attribute) use ($column) {
            $meta[$attribute] = collect($column->meta)->contains($attribute);

            return $meta;
        }, []);

        if ($column->meta['total']) {
            $this->template->total = true;
        }

        if ($column->meta['date']) {
            $this->template->date = true;
        }

        $column->meta['visible'] = true;
    }
}
