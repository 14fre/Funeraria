@extends('emails.layout')

@section('subject', 'Solicitud de afiliación aprobada - Funeraria San José')

@section('body')
    <p>Hola <strong>{{ $user->name }}</strong>,</p>
    <p>Te informamos que tu <strong>solicitud de afiliación</strong> ha sido <strong>aprobada</strong>.</p>
    <p>Ya puedes acceder a tu panel de cliente con tu usuario y contraseña para ver tu plan <strong>{{ $planNombre }}</strong>, gestionar beneficiarios y consultar tus pagos.</p>
    <p>
        <a href="{{ url('/cliente/dashboard') }}" style="display: inline-block; background: #5C0E2B; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: 600;">Ir a mi panel</a>
    </p>
    <p>Si tienes dudas, contáctanos. Estamos para ayudarte.</p>
    <p>Atentamente,<br><strong>Funeraria San José</strong></p>
@endsection
