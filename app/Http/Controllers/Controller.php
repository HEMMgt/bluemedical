<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    //retorna los minutos entre dos fechas
    public function getMinutes($fecha_ini,$fecha_fin){
        $to = Carbon::createFromFormat('Y-m-d H:i:s', $fecha_fin);
        $from = Carbon::createFromFormat('Y-m-d H:i:s', $fecha_ini);
        return  $to->diffInMinutes($from);
    }
}
