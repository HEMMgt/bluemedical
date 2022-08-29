<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Record;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    // crea el registro de que el invoice a sido pagado
    public function pay(Request $request)
    {
        // se valida la información 
        $validatedData = $request->validate([
            'identifier' => 'required|string|max:20',
        ]);
        // se verifica si la placa existe
        $invoice = Invoice::where('identifier', $validatedData['identifier'])
                            ->where('paid',0)->first();
        if (!$invoice) {
            return response()->json([
                'message' => "No se ha detectado el invoice o ya fue pagado",
            ]);
        } 
        
        //guardamos el registro 
        $invoice->paid      = 1;
        
        $invoice->save();
        return response()->json([
            'message' => "Pago realizado con éxito",
            'invoice' => $invoice,
        ]);
    }
    public function generate()
    {
        
        $invoices = DB::table('records')
             ->select(DB::raw('sum(minutes) as total_minutes,  car_id'))
             ->where('completado',  0)
             ->whereNotNull('check_out')
             ->groupBy('car_id')
             ->get();
        
        // recorremos todos los datos existentes si existen
        if (!$invoices) {
            return response()->json([
                'message' => "No hay registros para generar la carga",
            ]);
        }
        //creamos los nuevos invoices
        $new_invoices =[];
        foreach($invoices AS $invoice){
            $car = Car::findOrFail($invoice->car_id);
            $amount = $invoice->total_minutes * $car->type->rate;
            $identifier = time().$invoice->total_minutes;
            $invoice = Invoice::create([
                'car_id' => $car->id,
                'identifier' => $identifier,
                'minutes' => $invoice->total_minutes,
                'price' => $amount,
                'user_id' => auth()->user()->id,
            ]);
            $new_invoices[] = $invoice;

        }
        $records = Record::where('completado',  0)
                            ->whereNotNull('check_out')
                            ->update([
                                'completado' => 1
                            ]);
        return response()->json([
            'message' => "Facturas mensuales generadas  con éxito",
            'invoice' => $new_invoices, 
            'records' => $records, 
        ]);
    }
}
