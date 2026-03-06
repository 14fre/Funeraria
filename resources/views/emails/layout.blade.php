<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('subject', 'Funeraria San José')</title>
    <!--[if mso]>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f4f4;">
        <tr>
            <td align="center" style="padding: 32px 16px;">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
                    {{-- Encabezado igual que reporte: fondo oscuro vinotinto + cruz dorada --}}
                    <tr>
                        <td style="background-color: #5C0E2B; background: linear-gradient(135deg, #5C0E2B 0%, #3d0a1e 100%); padding: 24px 28px; text-align: center; border-radius: 8px 8px 0 0;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td align="center">
                                        <p style="margin: 0 0 6px 0; font-size: 28px; color: #FFD700; line-height: 1;">&#10013;</p>
                                        <p style="margin: 0; font-size: 11px; letter-spacing: 3px; color: #FFD700; text-transform: uppercase;">Funeraria</p>
                                        <h1 style="margin: 4px 0 0 0; font-size: 22px; font-weight: 600; color: #ffffff; letter-spacing: 1px;">San José</h1>
                                        <p style="margin: 6px 0 0 0; font-size: 11px; color: rgba(255,255,255,0.9);">Servicios exequiales con dignidad y respeto</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    {{-- Contenido --}}
                    <tr>
                        <td style="padding: 32px 36px; color: #333333; font-size: 15px; line-height: 1.6;">
                            @yield('body')
                        </td>
                    </tr>
                    {{-- Pie formal (estilo reporte: línea dorada) --}}
                    <tr>
                        <td style="background-color: #ffffff; padding: 16px 36px; border-top: 2px solid #FFD700; text-align: center;">
                            <p style="margin: 0; font-size: 12px; color: #5C0E2B; font-weight: 600;">Funeraria San José</p>
                            <p style="margin: 4px 0 0 0; font-size: 10px; color: #6b7280;">Uso interno. Confidencial. Si no reconoce esta comunicación, ignore el mensaje.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
