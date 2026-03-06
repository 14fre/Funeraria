@extends('emails.layout')

@section('subject', 'Restablecer contraseña - Funeraria San José')

@section('body')
    <p style="margin: 0 0 16px 0;">Estimado/a <strong>{{ $user->name }}</strong>:</p>
    <p style="margin: 0 0 16px 0;">Hemos recibido una solicitud para restablecer la contraseña de su cuenta. Utilice el siguiente enlace para establecer una nueva contraseña:</p>
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 20px 0;">
        <tr>
            <td>
                <a href="{{ $url }}" style="display: inline-block; background-color: #5C0E2B; color: #ffffff; padding: 12px 24px; text-decoration: none; font-size: 14px; font-weight: 600; border-radius: 6px;">Restablecer contraseña</a>
            </td>
        </tr>
    </table>
    <p style="margin: 0 0 8px 0; font-size: 13px; color: #666;">Este enlace expira en 60 minutos.</p>
    <p style="margin: 16px 0 0 0; font-size: 13px; color: #888;">Si no solicitó restablecer su contraseña, ignore este correo.</p>
@endsection
