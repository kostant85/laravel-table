<?php

namespace Kostant\Table\Classes\Attributes;

class Structure
{
    const Mandatory = ['routePrefix', 'readSuffix', 'columns'];

    const Optional = [
        'name', 'icon', 'crtNo', 'appends', 'buttons', 'writeSuffix', 'lengthMenu', 'auth', 'debounce',
    ];
}
