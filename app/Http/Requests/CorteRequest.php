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
            'imagen' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp,heic,heif', 'max:51200'], // 50MB
            'fecha' => ['required', 'date'],
            'estado' => ['required', 'in:0,1,2'],
        ];
    }

    public function messages()
    {
        return [
            'numero_corte.required' => 'El número de corte es requerido',
            'numero_corte.numeric' => 'El número de corte debe ser un número',
            'numero_corte.min' => 'El número de corte debe ser mayor a 0',
            'tipo_tela.required' => 'El tipo de tela es requerido',
            'tipo_tela.string' => 'El tipo de tela debe ser texto',
            'tipo_tela.min' => 'El tipo de tela debe tener al menos 2 caracteres',
            'tipo_tela.max' => 'El tipo de tela no puede tener más de 100 caracteres',
            'colores.required' => 'Los colores son requeridos',
            'colores.array' => 'Los colores deben ser un array',
            'colores.color.required' => 'Los colores son requeridos',
            'colores.color.array' => 'Los colores deben ser un array',
            'colores.color.min' => 'Debe especificar al menos un color',
            'colores.color.*.required' => 'El color es requerido',
            'colores.color.*.string' => 'El color debe ser texto',
            'colores.color.*.min' => 'El color debe tener al menos 1 carácter',
            'colores.color.*.max' => 'El color no puede tener más de 50 caracteres',
            'colores.cantidad.required' => 'Las cantidades son requeridas',
            'colores.cantidad.array' => 'Las cantidades deben ser un array',
            'colores.cantidad.min' => 'Debe especificar al menos una cantidad',
            'colores.cantidad.*.required' => 'La cantidad es requerida',
            'colores.cantidad.*.numeric' => 'La cantidad debe ser un número',
            'colores.cantidad.*.min' => 'La cantidad debe ser mayor a 0',
            'cantidad_total.required' => 'La cantidad total es requerida',
            'cantidad_total.numeric' => 'La cantidad total debe ser un número',
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
            'imagen.mimes' => 'El archivo debe ser una imagen de tipo: jpeg, png, jpg, gif, svg, webp, heic, heif',
            'imagen.max' => 'La imagen no debe superar los 50MB',
            'fecha.required' => 'El campo fecha es requerido',
            'fecha.date' => 'El campo fecha debe ser una fecha válida',
            'estado.required' => 'El campo estado es requerido',
            'estado.in' => 'El estado debe ser: Cortado, Costurando o Entregado'
        ];
    }
}
