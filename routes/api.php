<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TypeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('test', [TestController::class,'test']);


// Las rutas que estan protegisdas
Route::group(['middleware' => ['auth:api']], function () {
    //rutas prueba
    Route::get('privatetest', [TestController::class,'privatetest']);
    //ruta de los tipos de vehiculos
    Route::get('types/', [TypeController::class,'index'])->name('types');

    //rutas de vehiculos
    Route::get('cars', [CarController::class,'index'])->name('cars');
    Route::get('cars/{id}', [CarController::class,'show'])->name('cars.show');
    Route::post('cars', [CarController::class,'store'])->name('cars.store');
    Route::put('cars/{id}', [CarController::class,'update'])->name('cars.update');

    Route::get('cars/{id}/records', [CarController::class,'records'])->name('cars.records');
    Route::get('cars/{id}/invoices', [CarController::class,'invoices'])->name('cars.invoices');

    //rutas registros
    //crea el ingreso de una entrada al parqueo
    //todo carro no registrado como Oficial o Recidente se tomará como No Residente
    Route::post('records', [RecordController::class,'store'])->name('records.store');
    // guarda la salida del paqueo
    Route::post('records/out', [RecordController::class,'out'])->name('records.out');

    //rutas invoices
    //se realiza el pago del invoice
    Route::post('invoices', [InvoiceController::class,'pay'])->name('invoices.pay');
    //se genera los invoices de los clientes mensuales
    Route::post('invoices/generate', [InvoiceController::class,'generate'])->name('generate.generate');

    
 
});
// Rutas protegidas autorizacion
Route::group(['middleware' => ['auth:api'],'prefix' =>'/auth'], function () {
    //
    Route::get('logout', [AuthController::class,'logout'])->name('logout')->middleware('auth:api');
    Route::get('me', [AuthController::class,'me'])->name('me')->middleware('auth:api');
 
});
// Rutas libres autorización
Route::group(['prefix' =>'auth'], function () {
    //
    Route::post('register', [AuthController::class,'register'])->name('register');
    Route::post('login', [AuthController::class,'login'])->name('login');
 
});
