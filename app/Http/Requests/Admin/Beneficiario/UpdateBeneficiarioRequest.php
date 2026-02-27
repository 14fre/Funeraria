<?php

namespace App\Http\Requests\Admin\Beneficiario;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBeneficiarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('beneficiario')) ?? false;
    }

    public function rules(): array
    {
        $beneficiario = $this->route('beneficiario');
        return [
            'tipo_documento' => ['required', 'string', 'in:CC,CE,TI,PASAPORTE'],
            'numero_documento' => ['required', 'string', 'max:20', 'unique:beneficiarios,numero_documento,' . $beneficiario->id . ',id,tipo_documento,' . $this->input('tipo_documento')],
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'fecha_nacimiento' => ['required', 'date'],
            'genero' => ['nullable', 'string', 'in:M,F,Otro'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'parentesco' => ['required', 'string', 'max:50'],
            'direccion' => ['nullable', 'string', 'max:500'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'departamento' => ['nullable', 'string', 'max:100'],
            'activo' => ['boolean'],
        ];
    }
}
