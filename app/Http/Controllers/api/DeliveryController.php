<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\DeliveryStoreRequest;
use App\Models\DeliveryAddresse;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function address(DeliveryStoreRequest $request)
    {
        // $request->validate([
        //     'address' => 'string|max:255',
        //     'calle' => 'required|string',
        //     'numext' => 'required|string',
        //     'numint' => 'nullable|string',
        //     'colonia' => 'required|string',
        //     'codigo_postal' => 'required|string',
        //     'municipio' => 'required|string',
        //     'estado' => 'required|string',
        //     'direccion_entrega' => 'required|string',
        //     'nombre' => 'required|string',
        //     'apellido' => 'required|string',
        //     'telefono' => 'required|string',
        //     'url' => 'required|string',
        //     'user_id' => 'required'
        // ]);

        $numInt = '';
        if(!is_null($request->numint)){
            $numInt = $request->numint;
        }

        $deliveryAddresse = DeliveryAddresse::create([
            "description" => "user new address",
            "address" => $request->address,
            "is_default" => false,
            "user_id" => $request->user_id,
            'calle' => $request->calle,
            'numext' => $request->numext,
            'numint' => $numInt,
            'colonia' => $request->colonia,
            'codigo_postal' => $request->codigo_postal,
            'municipio' => $request->municipio,
            'estado' => $request->estado,
            'direccion_entrega' => $request->direccion_entrega,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'url' => $request->url,
        ]);

        return response()->json([
            'address' => $deliveryAddresse
        ]);
    }

    public function destroy($id)
    {
        $delivery = DeliveryAddresse::find($id);

        if($delivery->delete()) {
            return response()->json([
                'success' => true
            ], 200);
        }
    }
}
