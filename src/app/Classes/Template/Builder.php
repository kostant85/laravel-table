<?php

namespace Kostant\Table\Template;

use Kostant\Table\Classes\Template\Builders\Columns;
use Kostant\Table\Classes\Template\Builders\Structure;
use Kostant\Table\Classes\Template\Builders\Buttons;

class Builder
{
    private $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    public function run()
    {
        (new Structure($this->template))->build();
        (new Columns($this->template))->build();
        (new Buttons($this->template))->build();
    }
}
