<?php

namespace App\Http\Requests;

use http\Message;
use Illuminate\Foundation\Http\FormRequest;

class ArticuloRequest extends FormRequest
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
            'nombre' => ['required', 'min:3'],
            'descripcion' => ['required', 'min:3'],
            'precio' => ['required', 'numeric'],
            'precio_promocion' => ['nullable', 'numeric', 'min:0'],
            'categoria_id' => ['required', 'numeric', 'not_in:0'],
            'temporada_id' => ['required', 'numeric', 'not_in:0'],
            'imagen' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp,heic,heif', 'max:51200'], // 50MB
            'imagen_2' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp,heic,heif', 'max:51200'], // 50MB
            'imagen_3' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp,heic,heif', 'max:51200'], // 50MB
            'stock' => ['required', 'numeric'],
            'codigo' => ['required', 'min:3'],
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es requerido',
            'nombre.min' => 'El campo nombre debe tener al menos 3 caracteres',
            'descripcion.required' => 'El campo descripción es requerido',
            'descripcion.min' => 'El campo descripción debe tener al menos 3 caracteres',
            'precio.required' => 'El campo precio es requerido',
            'precio.numeric' => 'El campo precio debe ser numérico',
            'precio_promocion.numeric' => 'El campo precio promocional debe ser numérico',
            'precio_promocion.min' => 'El campo precio promocional debe ser mayor o igual a 0',
            'categoria_id.required' => 'El campo categoría es requerido',
            'categoria_id.numeric' => 'El campo categoría debe ser numérico',
            'categoria_id.not_in' => 'Seleccione una categoría',
            'temporada_id.required' => 'El campo temporada es requerido',
            'temporada_id.numeric' => 'El campo temporada debe ser numérico',
            'temporada_id.not_in' => 'Seleccione una temporada',
            'imagen.image' => 'El archivo debe ser una imagen',
            'imagen.mimes' => 'El archivo debe ser una imagen de tipo: jpeg, png, jpg, gif, svg, webp, heic, heif',
            'imagen.max' => 'La imagen no debe superar los 50MB',
            'imagen_2.image' => 'El archivo de la segunda imagen debe ser una imagen',
            'imagen_2.mimes' => 'El archivo de la segunda imagen debe ser de tipo: jpeg, png, jpg, gif, svg, webp, heic, heif',
            'imagen_2.max' => 'La segunda imagen no debe superar los 50MB',
            'imagen_3.image' => 'El archivo de la tercera imagen debe ser una imagen',
            'imagen_3.mimes' => 'El archivo de la tercera imagen debe ser de tipo: jpeg, png, jpg, gif, svg, webp, heic, heif',
            'imagen_3.max' => 'La tercera imagen no debe superar los 50MB',
            'stock.required' => 'El campo stock es requerido',
            'stock.numeric' => 'El campo stock debe ser numérico',
            'codigo.required' => 'El campo código es requerido',
            'codigo.min' => 'El campo código debe tener al menos 3 caracteres',
        ];
    }
}
