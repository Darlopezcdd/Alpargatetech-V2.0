<!DOCTYPE html>
<html>

<head>
    <title>Recuperación de Contraseña</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div
        style="max-w-md; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <h2 style="color: #333; text-align: center;">Código de Recuperación</h2>
        <p style="color: #555;">Hola,</p>
        <p style="color: #555;">Has solicitado restablecer tu contraseña en AlpargateTech. Usa el siguiente código para
            continuar:</p>
        <div style="background-color: #e0e7ff; padding: 15px; border-radius: 5px; text-align: center; margin: 20px 0;">
            <span style="font-size: 24px; font-weight: bold; color: #4338ca; letter-spacing: 5px;">{{ $code }}</span>
        </div>
        <p style="color: #555;">Este código expirará en 15 minutos.</p>
        <p style="color: #555;">Si no solicitaste este cambio, puedes ignorar este correo.</p>
    </div>
</body>

</html>