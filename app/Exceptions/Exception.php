<?php

namespace App\Exceptions;

use Exception;

class NotCreatedException extends Exception
{
    public function render($request)
    {
        return response()->json(['error' => $this->getMessage()], 400);
    }
}
