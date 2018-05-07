<?php

namespace Kostant\Table\Classes\Template;

use Kostant\Table\Classes\Template\Validators\Columns;
use Kostant\Table\Classes\Template\Validators\Structure;

class Validator
{
    private $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function run()
    {
        (new Structure($this->template))->validate();

        (new Columns($this->template))->validate();
    }
}
