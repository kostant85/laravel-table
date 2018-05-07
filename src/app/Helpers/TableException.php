<?php

namespace Kostant\Table\Helpers;

use Exception;

class TableException extends Exception
{
    public function __construct(string $message, int $code = 555)
    {
        parent::__construct($message, $code);
    }

    public function render()
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], $this->getCode());
    }
}
