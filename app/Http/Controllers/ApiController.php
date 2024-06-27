<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;

class ApiController extends Controller
{
    /**
    * is created in order to separate the laravel logic (Controller.php) from the custom api logic
    */
    use ApiResponse;
}