<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CorteRequest extends FormRequest
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
            'numero_corte' => ['required', 'numeric'],
            'nombre' => ['required', 'min:3'],
            'colores' => ['required', 'min:3'],
            'cantidad' => 'required',
            'articulos' => ['required', 'min:3'],
            'costureros' => ['required', 'min:3'],
            'imagen' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:8048'
        ];
    }

    public function messages()
    {
        return [
            'numero_corte.required' => 'El campo número de corte es requerido',
            'numero_corte.numeric' => 'El campo número de corte debe ser numérico',
            'nombre.required' => 'El campo nombre es requerido',
            'nombre.min' => 'El campo nombre debe tener al menos 3 caracteres',
            'colores.required' => 'El campo colores es requerido',
            'colores.min' => 'El campo colores debe tener al menos 3 caracteres',
            'cantidad.required' => 'El campo cantidad es requerido',
            'articulos.required' => 'El campo artículos es requerido',
            'articulos.min' => 'El campo artículos debe tener al menos 3 caracteres',
            'costureros.required' => 'El campo costureros es requerido',
            'costureros.min' => 'El campo costureros debe tener al menos 3 caracteres',
            'imagen.image' => 'El archivo debe ser una imagen',
            'imagen.mimes' => 'El archivo debe ser una imagen de tipo: jpeg, png, jpg, gif, svg, webp'
        ];
    }
}
