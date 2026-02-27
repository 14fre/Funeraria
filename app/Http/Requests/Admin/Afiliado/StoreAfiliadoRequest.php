<?php

namespace App\Http\Requests\Admin\Afiliado;

use Illuminate\Foundation\Http\FormRequest;

class StoreAfiliadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', \App\Models\Afiliado::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'plan_exequial_id' => ['required', 'exists:planes_exequiales,id'],
            'numero_afiliacion' => ['nullable', 'string', 'max:50', 'unique:afiliados,numero_afiliacion'],
            'fecha_afiliacion' => ['required', 'date'],
            'estado' => ['required', 'in:activo,suspendido,cancelado,mora'],
            'asesor_id' => ['nullable', 'exists:users,id'],
            'observaciones' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'user_id' => 'usuario',
            'plan_exequial_id' => 'plan exequial',
            'numero_afiliacion' => 'número de afiliación',
            'fecha_afiliacion' => 'fecha de afiliación',
            'asesor_id' => 'asesor',
        ];
    }
}
