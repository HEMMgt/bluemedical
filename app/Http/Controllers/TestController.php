<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function test(Request $request)
    {
        return 'Prueba sin validar';
    }
    public function privatetest(Request $request)
    {
        return 'Mensaje privado solo visto por usuarios';
    }
}
