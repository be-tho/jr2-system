<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVentaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cliente_nombre' => 'nullable|string|max:255',
            'notas' => 'nullable|string|max:1000',
            'items' => 'required|array|min:1',
            'items.*.articulo_id' => 'required|exists:articulos,id',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.precio_unitario' => 'required|numeric|min:0',
            'items.*.detalle' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'items.required' => 'Debe agregar al menos un artículo a la venta.',
            'items.min' => 'Debe agregar al menos un artículo a la venta.',
            'items.*.articulo_id.required' => 'El artículo es requerido.',
            'items.*.articulo_id.exists' => 'El artículo seleccionado no existe.',
            'items.*.cantidad.required' => 'La cantidad es requerida.',
            'items.*.cantidad.integer' => 'La cantidad debe ser un número entero.',
            'items.*.cantidad.min' => 'La cantidad debe ser mayor a 0.',
            'items.*.precio_unitario.required' => 'El precio unitario es requerido.',
            'items.*.precio_unitario.numeric' => 'El precio unitario debe ser un número.',
            'items.*.precio_unitario.min' => 'El precio unitario debe ser mayor o igual a 0.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'cliente_nombre' => 'nombre del cliente',
            'notas' => 'notas',
            'items' => 'artículos',
            'items.*.articulo_id' => 'artículo',
            'items.*.cantidad' => 'cantidad',
            'items.*.precio_unitario' => 'precio unitario',
            'items.*.detalle' => 'detalle',
        ];
    }
}