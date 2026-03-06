<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactoController extends Controller
{
    /**
     * Mostrar formulario de contacto.
     */
    public function index(): View
    {
        return view('contacto');
    }

    /**
     * Guardar mensaje y enviar correo a la funeraria.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'asunto' => ['required', 'string', 'max:255'],
            'mensaje' => ['required', 'string', 'max:5000'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Indica un correo válido.',
            'asunto.required' => 'El asunto es obligatorio.',
            'mensaje.required' => 'El mensaje es obligatorio.',
        ]);

        $contacto = Contacto::create([
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'telefono' => $validated['telefono'] ?? null,
            'asunto' => $validated['asunto'],
            'mensaje' => $validated['mensaje'],
            'ip' => $request->ip(),
        ]);

        $emailFuneraria = empresa_config('empresa_email', config('funeraria.email', config('mail.from.address')));

        try {
            Mail::send('emails.contacto-recibido', ['contacto' => $contacto], function ($message) use ($emailFuneraria, $contacto) {
                $message->to($emailFuneraria)
                    ->replyTo($contacto->email, $contacto->nombre)
                    ->subject('Mensaje de contacto: ' . $contacto->asunto);
            });
        } catch (\Throwable $e) {
            // Mensaje guardado; solo falla el envío de correo
            report($e);
        }

        return redirect()->route('contacto')->with('success', 'Tu mensaje ha sido enviado correctamente. Te responderemos a la brevedad.');
    }
}
