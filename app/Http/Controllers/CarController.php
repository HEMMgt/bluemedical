<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;


class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return   Car::all();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // se valida la información 
        $validatedData = $request->validate([
            'identifier' => 'required|string|max:8|unique:cars,identifier'
        ]);
        // se verifica que el tipo de vehiculo venga
        if ($request->has('type')) {
            $type = $request->input('type');
        } else {
            $type = 3;
        }

        $car = Car::create([
            'identifier' => $validatedData['identifier'],
            'type_id' => $type
        ]);
        return response()->json([
            'placa' => $car->identifier,
            'type' => $car->type->name,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Se busca por el # placa
    public function show($id)
    {
        $car = Car::where('identifier', $id)->first();
        if ($car) {
            return response()->json([
                'placa' => $car->identifier,
                'type' => $car->type->name,
                'records' => $car->records,
                'invoices' => $car->invoices,
            ]);
        } else {
            return response()->json([
                'message' => "Problemas de busqueda",
                'error' => "El código enviado es inválido o no existe",
            ]);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // se envia el numero de placa para actualizar
    public function update(Request $request, $id)
    {
        // se valida la información 
        $request->validate([
            'identifier' => [
                'required',
                'string',
                'max:8',
                'unique:cars,identifier',

            ]
        ]);


        $car = Car::where('identifier', $id)->first();
        //validamos si encontro la consulta
        if ($car) {
            $car->identifier = $request->input('identifier');
            // se verifica que el tipo de vehiculo venga
            if ($request->has('type')) {
                $car->type_id =  $request->input('type');
            }
            // $car->save();
            return response()->json([
                'placa' => $car->identifier,
                'type' => $car->type->name,
            ]);
        } else {
            return response()->json([
                'message' => "Problemas de busqueda",
                'error' => "El código enviado es inválido o no existe",
            ]);
        }
    }
    /**
     * Display the list records.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Se busca por el # placa
    public function records($id)
    {
        $car = Car::where('identifier', $id)->first();
        if ($car) {
            //verificamos que existen registro
            if($car->records){
                return $car->records;
            }else{
                return response()->json([
                    'message' => "No existe ningún registro",
                ]);
            }
        } else {
            return response()->json([
                'message' => "Problemas de busqueda",
                'error' => "El código enviado es inválido o no existe",
            ]);
        }
    }
    /**
     * Display the list invoices.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Se busca por el # placa
    public function invoices($id)
    {
        $car = Car::where('identifier', $id)->first();
        if ($car) {
            //verificamos que exista registro
            if($car->invoices){
                return $car->invoices;
            }else{
                return response()->json([
                    'message' => "No existe ningún registro",
                ]);
            }
        } else {
            return response()->json([
                'message' => "Problemas de busqueda",
                'error' => "El código enviado es inválido o no existe",
            ]);
        }
    }
}
