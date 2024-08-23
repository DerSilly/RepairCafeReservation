<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponses; // Add this line to import the ApiResponses trait

class AuthController extends Controller
{
    use ApiResponses; // Add this line to use the ApiResponses trait
    public function login() {
        return $this->ok('Hello Login!');
    }
}
