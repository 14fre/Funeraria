@extends('emails.layout')

@section('subject', 'Código para cambiar contraseña - Funeraria San José')

@section('body')
    <p style="margin: 0 0 16px 0;">Estimado/a <strong>{{ $user->name }}</strong>:</p>
    <p style="margin: 0 0 16px 0;">Ha solicitado cambiar la contraseña de su cuenta. Utilice el siguiente código para confirmar el cambio:</p>
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 20px 0;">
        <tr>
            <td style="background-color: #5C0E2B; color: #ffffff; padding: 14px 28px; font-size: 22px; letter-spacing: 6px; font-weight: 600; border-radius: 6px;">{{ $code }}</td>
        </tr>
    </table>
    <p style="margin: 0 0 8px 0; font-size: 14px; color: #666;">Este código es válido durante <strong>10 minutos</strong> y es de uso único.</p>
    <p style="margin: 16px 0 0 0; font-size: 13px; color: #888;">Si no solicitó este cambio, ignore este mensaje y mantenga su contraseña actual.</p>
@endsection
