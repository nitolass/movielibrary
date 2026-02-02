<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenido a MovieApp</title>
</head>
<body style="margin: 0; padding: 0; background-color: #16181c; font-family: 'Arial', sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color: #16181c; padding: 40px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #000000; border: 1px solid #333333; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.5);">
                <tr>
                    <td align="center" style="padding: 30px; background-color: #1f2937; border-bottom: 1px solid #333;">
                        <h1 style="color: #ffffff; margin: 0; font-size: 24px;">Movie<span style="color: #eab308;">Hub</span> 🎬</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 40px; text-align: center;">
                        <h2 style="color: #ffffff; font-size: 22px; margin-bottom: 20px;">¡Bienvenido, {{ $user->name }}! 👋</h2>
                        <p style="color: #9ca3af; font-size: 16px; line-height: 1.6; margin-bottom: 30px;">
                            Gracias por unirte a nuestra comunidad. Estamos encantados de tenerte aquí. Prepárate para descubrir, calificar y organizar las mejores películas del mundo.
                        </p>

                        <a href="{{ url('/') }}" style="background-color: #eab308; color: #000000; padding: 14px 28px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block;">
                            Ir al Catálogo
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px; text-align: center; border-top: 1px solid #333; color: #555; font-size: 12px;">
                        &copy; {{ date('Y') }} MovieHub. Todos los derechos reservados.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
