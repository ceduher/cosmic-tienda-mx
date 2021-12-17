<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address' => 'required|string|max:255',
            'calle' => 'required|string',
            'numext' => 'required|string',
            'numint' => 'nullable|string',
            'colonia' => 'required|string',
            'codigo_postal' => 'required|string',
            'municipio' => 'required|string',
            'estado' => 'required|string',
            'direccion_entrega' => 'required|string',
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'telefono' => 'required|string',
            'url' => 'string',
            'user_id' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'address.required' => 'El campo dirección es obligatorio',
            'calle.required' => 'El campo calle es obligatorio',
            'numext.required' => 'El campo N° exterior es obligatorio',
            'numint.required' => 'El campo N° interior es obligatorio',
            'colonia.required' => 'El campo colonia es obligatorio',
            'codigo_postal.required' => 'El campo codigo postal es obligatorio',
            'municipio.required' => 'El campo municipio es obligatorio',
            'estado.required' => 'El campo estado es obligatorio',
            'direccion_entrega.required' => 'El campo dirección de entrega es obligatorio',
            'nombre.required' => 'El campo nombre en dirección es obligatorio',
            'apellido.required' => 'El campo apellido en dirección es obligatorio',
            'telefono.required' => 'El campo telefono en dirección es obligatorio',
            'url.required' => '',
        ];
    }
}
