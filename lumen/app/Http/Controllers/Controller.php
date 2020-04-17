<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function sanitizeString(string $string){
        return trim(filter_var($string, FILTER_SANITIZE_STRING));
    }
}
