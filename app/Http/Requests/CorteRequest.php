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
            'numero_corte' => ['required', 'numeric', 'min:1'],
            'tipo_tela' => ['required', 'string', 'min:2', 'max:100'],
            'colores' => ['required', 'array'],
            'colores.color' => ['required', 'array', 'min:1'],
            'colores.color.*' => ['required', 'string', 'min:1', 'max:50'],
            'colores.cantidad' => ['required', 'array', 'min:1'],
            'colores.cantidad.*' => ['required', 'numeric', 'min:1'],
            'cantidad_total' => ['required', 'numeric', 'min:1'],
            'articulos' => ['required', 'string', 'min:3'],
            'descripcion' => ['required', 'string', 'min:3'],
            'costureros' => ['required', 'string', 'min:3'],
            'imagen' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:20480'],
            'fecha' => ['required', 'date'],
            'estado' => ['required', 'in:0,1,2'],
        ];
    }

    public function messages()
    {
        return [
            'numero_corte.required' => 'El campo número de corte es requerido',
            'numero_corte.numeric' => 'El campo número de corte debe ser numérico',
            'numero_corte.min' => 'El número de corte debe ser mayor a 0',
            'tipo_tela.required' => 'El campo tipo de tela es requerido',
            'tipo_tela.string' => 'El campo tipo de tela debe ser texto',
            'tipo_tela.min' => 'El campo tipo de tela debe tener al menos 2 caracteres',
            'tipo_tela.max' => 'El campo tipo de tela no debe superar los 100 caracteres',
            'colores.required' => 'Debe agregar al menos un color',
            'colores.array' => 'El campo colores debe ser un array',
            'colores.color.required' => 'Debe especificar los colores',
            'colores.color.array' => 'Los colores deben ser un array',
            'colores.color.min' => 'Debe agregar al menos un color',
            'colores.color.*.required' => 'El nombre del color es requerido',
            'colores.color.*.string' => 'El nombre del color debe ser texto',
            'colores.color.*.min' => 'El nombre del color debe tener al menos 1 caracter',
            'colores.color.*.max' => 'El nombre del color no debe superar los 50 caracteres',
            'colores.cantidad.required' => 'Debe especificar las cantidades',
            'colores.cantidad.array' => 'Las cantidades deben ser un array',
            'colores.cantidad.min' => 'Debe agregar al menos una cantidad',
            'colores.cantidad.*.required' => 'La cantidad es requerida',
            'colores.cantidad.*.numeric' => 'La cantidad debe ser numérica',
            'colores.cantidad.*.min' => 'La cantidad debe ser mayor a 0',
            'cantidad_total.required' => 'El campo cantidad total es requerido',
            'cantidad_total.numeric' => 'El campo cantidad total debe ser numérico',
            'cantidad_total.min' => 'La cantidad total debe ser mayor a 0',
            'articulos.required' => 'El campo artículos es requerido',
            'articulos.string' => 'El campo artículos debe ser texto',
            'articulos.min' => 'El campo artículos debe tener al menos 3 caracteres',
            'descripcion.required' => 'El campo descripción es requerido',
            'descripcion.string' => 'El campo descripción debe ser texto',
            'descripcion.min' => 'El campo descripción debe tener al menos 3 caracteres',
            'costureros.required' => 'El campo costureros es requerido',
            'costureros.string' => 'El campo costureros debe ser texto',
            'costureros.min' => 'El campo costureros debe tener al menos 3 caracteres',
            'imagen.image' => 'El archivo debe ser una imagen',
            'imagen.mimes' => 'El archivo debe ser una imagen de tipo: jpeg, png, jpg, gif, svg, webp',
            'imagen.max' => 'La imagen no debe superar los 8MB',
            'fecha.required' => 'El campo fecha es requerido',
            'fecha.date' => 'El campo fecha debe ser una fecha válida',
            'estado.required' => 'El campo estado es requerido',
            'estado.in' => 'El estado debe ser: Cortado, Costurando o Entregado'
        ];
    }
}
