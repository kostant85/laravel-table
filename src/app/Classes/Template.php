<?php

namespace Kostant\Table\Classes;

use Kostant\Table\Template\Builder;

class Template
{
    private $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function get()
    {
        (new Builder($this->template))->run();

        return ['template' => $this->template];
    }

}
