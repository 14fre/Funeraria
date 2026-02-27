<?php

namespace App\Http\Requests\Admin\Beneficiario;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeneficiarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', \App\Models\Beneficiario::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'afiliado_id' => ['required', 'exists:afiliados,id'],
            'tipo_documento' => ['required', 'string', 'in:CC,CE,TI,PASAPORTE'],
            'numero_documento' => ['required', 'string', 'max:20'],
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
