@extends('emails.layout')

@section('subject', 'Nuevo mensaje de contacto - Funeraria San José')

@section('body')
    <p>Se ha recibido un nuevo mensaje desde el formulario de contacto del sitio web.</p>
    <table role="presentation" style="width:100%; border-collapse: collapse; margin: 16px 0;">
        <tr><td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Nombre:</strong></td><td style="padding: 8px 0; border-bottom: 1px solid #eee;">{{ $contacto->nombre }}</td></tr>
        <tr><td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Email:</strong></td><td style="padding: 8px 0; border-bottom: 1px solid #eee;"><a href="mailto:{{ $contacto->email }}">{{ $contacto->email }}</a></td></tr>
        @if($contacto->telefono)
        <tr><td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Teléfono:</strong></td><td style="padding: 8px 0; border-bottom: 1px solid #eee;">{{ $contacto->telefono }}</td></tr>
        @endif
        <tr><td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Asunto:</strong></td><td style="padding: 8px 0; border-bottom: 1px solid #eee;">{{ $contacto->asunto }}</td></tr>
    </table>
    <p><strong>Mensaje:</strong></p>
    <p style="white-space: pre-wrap; background: #f5f5f5; padding: 12px; border-radius: 6px;">{{ $contacto->mensaje }}</p>
    <p style="font-size: 12px; color: #6b7280;">Recibido el {{ $contacto->created_at->format('d/m/Y H:i') }}.</p>
@endsection
