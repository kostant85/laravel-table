<?php

namespace Kostant\Table\Classes\Template\Validators;

use Kostant\Table\Exceptions\TemplateException;
use Kostant\Table\Classes\Attributes\Meta as Attributes;

class Meta
{
    public static function validate($meta)
    {
        $diff = collect($meta)
            ->diff(Attributes::List);

        if ($diff->isNotEmpty()) {
            throw new TemplateException(__(
                'Unknown Meta Parameter(s): ":attr"',
                ['attr' => $diff->implode('", "')]
            ));
        }
    }
}
