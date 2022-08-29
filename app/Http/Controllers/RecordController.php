<?php
namespace App\Http\Controllers;


use App\Models\Car;
use App\Models\Record;
use App\Models\Invoice;

use Illuminate\Http\Request;

class RecordController extends Controller
{
    // crea el registro de entrada de vehiculo
    public function store(Request $request)
    {
        // se valida la información 
        $validatedData = $request->validate([
            'identifier' => 'required|string|max:8',
        ]);
        // se verifica si la placa existe
        $car = Car::where('identifier', $request->input('identifier'))->first();
        if (!$car) {
            $car = Car::create([
                'identifier' => $validatedData['identifier'],
                'type_id' => 3
            ]);  
        } 
        $record = Record::create([
            'car_id' => $car->id,
            'check_in' => date('Y-m-d H:i:s'),
            'user_check_in' => auth()->user()->id,
            'user_id' => auth()->user()->id,
        ]);
        return response()->json([
            'message' => "Registro creado con exito",
            'records' => $record,
        ]);
    }
    // crea el registro de salida de vehiculo
    public function out(Request $request)
    {
        // se valida la información 
        $validatedData = $request->validate([
            'identifier' => 'required|string|max:8',
        ]);
        // se verifica si la placa existe
        $car = Car::where('identifier', $validatedData['identifier'])->first();
        if (!$car) {
            return response()->json([
                'message' => "No se ha detectado el vehiculo",
            ]);
        } 
        // se valida si el record existe
        $record = Record::where('car_id',$car->id)
                                ->whereNull('check_out')
                                ->where('completado',0)
                                ->first();
        if (!$record) {
            return response()->json([
                'message' => "No se ha detectado el registro de entrada del vehiculo",
            ]);
        }
        //guardamos el registro 
        $record->check_out      = date('Y-m-d H:i:s');
        $record->user_check_out = auth()->user()->id;
        // obtenemos los minutos 
        $minutes = $this->getMinutes($record->check_in,$record->check_out);
        $record->minutes = $minutes;
        $record->save();
        // verficiamos si genera cobro diario
        if($car->type->monthly ==0 AND $car->type->rate >0){
            //calculo de minutos
            $amount = round($car->type->rate*$minutes,2);
            //actualizamos el estado
            $record->completado = 1;
            $record->save();
            //generando pago
            $invoice = Invoice::create([
                'car_id' => $car->id,
                'identifier' => time().$car->id,
                'minutes' => $minutes,
                'price' => $amount,
                'user_id' => auth()->user()->id,
            ]);  
            return response()->json([
                'genero_cobro' => 1,
                'message' => "Registro de salida realizado con exito",
                'record' => $record,
                'cobro' => $invoice,
            ]);

        }
        elseif($car->type->rate ==0){
            // cerramos el registro
            $record->completado = 1;
            $record->save();
        }
        
        return response()->json([
            'genero_cobro' => 0,
            'message' => "Registro de salida realizado con exito",
            'record' => $record,
        ]);
    }
}
