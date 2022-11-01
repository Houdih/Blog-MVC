<?php

namespace App\Src\Exception;

use Exception;

class ViewNotFoundException extends Exception
{
    public function __construct($message = "La page n'existe pas !")
    {
        parent::__construct($message);
    }
}