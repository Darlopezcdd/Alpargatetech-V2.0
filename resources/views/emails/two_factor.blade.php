<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Verificación - Alpargate 3</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f3f4f6; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;">
    
    <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="background-color: #f3f4f6; padding: 40px 0;">
        <tr>
            <td align="center">
                
                <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    
                    <tr>
                        <td style="background-color: #010101; padding: 20px; text-align: center; border-bottom: 2px solid #D9BFA2;">
                            <h1 style="color: #ffffff; font-family: 'Georgia', serif; font-size: 24px; margin: 0; letter-spacing: 1px;">Alpargate 3</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 40px 30px; text-align: center;">
                            <div style="margin-bottom: 20px;">
                                <img src="https://cdn-icons-png.flaticon.com/512/2438/2438078.png" alt="Security" width="50" style="opacity: 0.8;">
                            </div>
                            
                            <h2 style="color: #010101; font-family: 'Georgia', serif; font-size: 22px; margin-top: 0; margin-bottom: 10px;">Verificación de Acceso</h2>
                            
                            <p style="color: #666666; font-size: 15px; line-height: 1.6; margin-bottom: 25px;">
                                Hola de parte de Alfonso. Para ingresar al sistema de forma segura, utiliza el siguiente código de verificación:
                            </p>

                            <div style="background-color: #FDFBF7; border: 1px dashed #D9BFA2; border-radius: 8px; padding: 20px; margin: 30px 0;">
                                <span style="display: block; color: #010101; font-size: 32px; font-weight: bold; letter-spacing: 8px; font-family: monospace;">{{ $code }}</span>
                            </div>

                            <p style="color: #999999; font-size: 13px; margin-top: 30px;">
                                Este código vencerá en <strong>10 minutos</strong>.
                            </p>
                            
                            <p style="color: #999999; font-size: 13px; margin-bottom: 0;">
                                Si no intentaste iniciar sesión, por favor cambia tu contraseña inmediatamente.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #eeeeee;">
                            <p style="color: #aaaaaa; font-size: 12px; margin: 0;">
                                &copy; {{ date('Y') }} Alpargate 3 - La Casa de Alfonso.
                            </p>
                        </td>
                    </tr>
                    
                </table>

            </td>
        </tr>
    </table>

</body>
</html>