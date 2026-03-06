<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuracion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConfiguracionController extends Controller
{
    public function index(): View
    {
        $settings = [
            'empresa_nombre' => Configuracion::obtener('empresa_nombre', config('funeraria.nombre')),
            'empresa_direccion' => Configuracion::obtener('empresa_direccion', config('funeraria.direccion_principal')),
            'empresa_ciudad' => Configuracion::obtener('empresa_ciudad', config('funeraria.ciudad')),
            'empresa_telefonos' => Configuracion::obtener('empresa_telefonos', implode(' - ', config('funeraria.telefonos', []))),
            'empresa_email' => Configuracion::obtener('empresa_email', config('funeraria.email')),
            'empresa_whatsapp' => Configuracion::obtener('empresa_whatsapp', config('services.whatsapp.number', '573186298729')),
            'empresa_horario' => Configuracion::obtener('empresa_horario', 'Emergencias 24/7 — Disponibles las 24 horas del día, los 365 días del año'),
        ];

        return view('admin.configuracion.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'empresa_nombre' => ['required', 'string', 'max:255'],
            'empresa_direccion' => ['required', 'string', 'max:255'],
            'empresa_ciudad' => ['required', 'string', 'max:255'],
            'empresa_telefonos' => ['required', 'string', 'max:255'],
            'empresa_email' => ['required', 'email', 'max:255'],
            'empresa_whatsapp' => ['nullable', 'string', 'max:30'],
            'empresa_horario' => ['nullable', 'string', 'max:255'],
        ]);

        $pairs = [
            'empresa_nombre' => ['tipo' => 'text', 'descripcion' => 'Nombre comercial de la funeraria'],
            'empresa_direccion' => ['tipo' => 'text', 'descripcion' => 'Dirección principal'],
            'empresa_ciudad' => ['tipo' => 'text', 'descripcion' => 'Ciudad y departamento'],
            'empresa_telefonos' => ['tipo' => 'text', 'descripcion' => 'Teléfonos de contacto (separados por guiones)'],
            'empresa_email' => ['tipo' => 'text', 'descripcion' => 'Correo principal de contacto'],
            'empresa_whatsapp' => ['tipo' => 'text', 'descripcion' => 'Número de WhatsApp en formato internacional, ej: 573186298729'],
            'empresa_horario' => ['tipo' => 'text', 'descripcion' => 'Horario de atención mostrado en la página de contacto'],
        ];

        foreach ($pairs as $clave => $meta) {
            Configuracion::establecer(
                $clave,
                $data[$clave] ?? '',
                $meta['tipo'],
                $meta['descripcion'],
                'empresa'
            );
        }

        return redirect()->route('admin.configuracion.index')->with('success', 'Configuración actualizada correctamente.');
    }
}

