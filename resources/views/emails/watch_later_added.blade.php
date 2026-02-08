<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="margin: 0; padding: 0; background-color: #16181c; font-family: 'Arial', sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color: #16181c; padding: 40px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #000000; border-top: 4px solid #eab308; border-radius: 8px; overflow: hidden;">
                <tr>
                    <td style="padding: 40px; text-align: center;">
                        <h1 style="font-size: 40px; margin: 0 0 20px 0;">🕒</h1>

                        <h2 style="color: #ffffff; margin-bottom: 10px;">{{ __('¡Guardada para después!') }}</h2>
                        <p style="color: #9ca3af; margin-bottom: 30px;">
                            {{ __('No te preocupes,') }} <strong>{{ $movie->title }}</strong> {{ __('estará esperándote cuando tengas tiempo.') }}
                        </p>

                        <div style="background-color: #1f2937; padding: 20px; border-radius: 8px; border-left: 3px solid #eab308; text-align: left;">
                            <h3 style="color: #fff; margin: 0; font-size: 16px;">{{ $movie->title }}</h3>
                            <p style="color: #9ca3af; margin: 5px 0 0 0; font-size: 13px;">
                                {{ Str::limit($movie->description, 80) }}
                            </p>
                        </div>

                        <p style="margin-top: 30px;">
                            <a href="{{ route('user.watch_later') }}" style="background-color: #333; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-size: 14px;">{{ __('Ir a mi lista pendiente') }}</a>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
