@extends('emails.layout')

@section('subject', 'Código de verificación - Funeraria San José')

@section('body')
    <p style="margin: 0 0 16px 0;">Estimado/a <strong>{{ $user->name }}</strong>:</p>
    <p style="margin: 0 0 16px 0;">Ha solicitado iniciar sesión en su cuenta. Para continuar, utilice el siguiente código de verificación.</p>
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 20px 0;">
        <tr>
            <td style="background-color: #5C0E2B; color: #ffffff; padding: 14px 28px; font-size: 22px; letter-spacing: 6px; font-weight: 600; border-radius: 6px;">{{ $code }}</td>
        </tr>
    </table>
    <p style="margin: 0 0 8px 0; font-size: 14px; color: #666;">Este código es válido durante <strong>10 minutos</strong> y es de uso único.</p>
    <p style="margin: 16px 0 0 0; font-size: 13px; color: #888;">Si no ha solicitado este código, ignore este mensaje y considere cambiar su contraseña.</p>
@endsection
