<?php

namespace Kostant\Table\Classes\Template\Builders;

class Structure
{
    private $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function build()
    {
        $this->setLengthMenu()
	        ->setDebounce()
            ->setDefaults();
    }
	
    private function setLengthMenu()
    {
        if (!property_exists($this->template, 'lengthMenu')) {
            $this->template->lengthMenu = config('table.lengthMenu');
        }

        return $this;
    }

    private function setDebounce()
    {
        if (!property_exists($this->template, 'debounce')) {
            $this->template->debounce = config('table.debounce');
        }

        return $this;
    }

    private function setDefaults()
    {
        $this->template->total = false;
        $this->template->date = false;
        $this->template->searchable = false;
        $this->template->labels = config('table.labels');
    }
}
