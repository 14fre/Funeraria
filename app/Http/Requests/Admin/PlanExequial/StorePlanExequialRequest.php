<?php

namespace App\Http\Requests\Admin\PlanExequial;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanExequialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', \App\Models\PlanExequial::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255', 'unique:planes_exequiales,nombre'],
            'descripcion' => ['nullable', 'string'],
            'tipo' => ['required', 'in:individual,familiar,empresarial,anticipado'],
            'max_beneficiarios' => ['required', 'integer', 'min:1', 'max:100'],
            'precio_mensual' => ['required', 'numeric', 'min:0'],
            'precio_anual' => ['required', 'numeric', 'min:0'],
            'servicios_incluidos' => ['nullable', 'array'],
            'servicios_incluidos.*' => ['string', 'max:100'],
            'activo' => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'max_beneficiarios' => 'máximo de beneficiarios',
            'precio_mensual' => 'precio mensual',
            'precio_anual' => 'precio anual',
            'servicios_incluidos' => 'servicios incluidos',
        ];
    }
}
