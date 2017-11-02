<?php

namespace App\Http\Controllers;

use App\helloWorld;


class helloWorldController extends Controller
{
    public function getHelloWorld()
    {
        $helloWorld = new helloWorld();
        return $helloWorld->toJson(JSON_PRETTY_PRINT);
    }
}
