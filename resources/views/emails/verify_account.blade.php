<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="margin: 0; padding: 0; background-color: #16181c; font-family: 'Arial', sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color: #16181c; padding: 40px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #000000; border: 1px solid #333333; border-radius: 16px; overflow: hidden;">
                <tr>
                    <td style="padding: 40px; text-align: center;">
                        <div style="background-color: rgba(234, 179, 8, 0.1); width: 60px; height: 60px; border-radius: 50%; margin: 0 auto 20px auto; line-height: 60px;">
                            <span style="font-size: 30px;">🔒</span>
                        </div>

                        <h2 style="color: #ffffff; margin-bottom: 15px;">{{ __('Verifica tu correo') }}</h2>
                        <p style="color: #9ca3af; line-height: 1.6; margin-bottom: 30px;">
                            {{ __('Hola') }} {{ $user->name }}, {{ __('necesitamos confirmar que este correo es tuyo para asegurar tu cuenta.') }}
                        </p>

                        <a href="#" style="background-color: #eab308; color: #000000; padding: 14px 28px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block;">
                            {{ __('Confirmar mi cuenta') }}
                        </a>

                        <p style="color: #555; font-size: 12px; margin-top: 30px;">
                            {{ __('Si no creaste una cuenta, puedes ignorar este mensaje.') }}
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
