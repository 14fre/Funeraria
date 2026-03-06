<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contacto;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactoController extends Controller
{
    /**
     * Listado de mensajes del formulario de contacto.
     */
    public function index(): View
    {
        $contactos = Contacto::query()
            ->orderByDesc('created_at')
            ->paginate(15);

        $noLeidos = Contacto::where('leido', false)->count();

        return view('admin.contactos.index', [
            'contactos' => $contactos,
            'noLeidos' => $noLeidos,
        ]);
    }

    /**
     * Ver un mensaje y marcar como leído.
     */
    public function show(Contacto $contacto): View
    {
        if (! $contacto->leido) {
            $contacto->update(['leido' => true]);
        }

        return view('admin.contactos.show', compact('contacto'));
    }

    /**
     * Marcar como leído sin entrar al detalle.
     */
    public function marcarLeido(Contacto $contacto): RedirectResponse
    {
        if (! $contacto->leido) {
            $contacto->update(['leido' => true]);
        }

        return redirect()->route('admin.contactos.index')->with('success', 'Mensaje marcado como leído.');
    }
}

