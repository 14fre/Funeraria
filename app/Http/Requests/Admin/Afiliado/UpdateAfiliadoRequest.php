<?php

namespace App\Http\Requests\Admin\Afiliado;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAfiliadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('afiliado')) ?? false;
    }

    public function rules(): array
    {
        $afiliado = $this->route('afiliado');

        return [
            'plan_exequial_id' => ['required', 'exists:planes_exequiales,id'],
            'fecha_afiliacion' => ['required', 'date'],
            'estado' => ['required', 'in:activo,suspendido,cancelado,mora'],
            'asesor_id' => ['nullable', 'exists:users,id'],
            'observaciones' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'plan_exequial_id' => 'plan exequial',
            'fecha_afiliacion' => 'fecha de afiliación',
            'asesor_id' => 'asesor',
        ];
    }
}
