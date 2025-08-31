<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CostureroRequest extends FormRequest
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
        $costureroId = $this->route('costurero');
        
        return [
            'nombre_completo' => 'required|string|max:255',
            'direccion' => 'required|string|max:1000',
            'celular' => 'required|string|max:20|unique:costureros,celular,' . $costureroId,
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nombre_completo.required' => 'El nombre completo es obligatorio.',
            'nombre_completo.max' => 'El nombre completo no puede tener más de 255 caracteres.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no puede tener más de 1000 caracteres.',
            'celular.required' => 'El número de celular es obligatorio.',
            'celular.max' => 'El número de celular no puede tener más de 20 caracteres.',
            'celular.unique' => 'Este número de celular ya está registrado.',
        ];
    }
}
