<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nuevo Estreno</title>
</head>
<body style="margin: 0; padding: 0; background-color: #16181c; font-family: 'Arial', sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color: #16181c; padding: 40px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #000000; border: 1px solid #333333; border-radius: 16px; overflow: hidden;">
                <tr>
                    <td align="center" style="padding: 30px; background-color: #1f2937;">
                        <span style="background-color: #eab308; color: #000; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase;">¡Nuevo Estreno!</span>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 40px; text-align: center;">
                        @if($movie->poster)
                            <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" style="width: 200px; border-radius: 12px; box-shadow: 0 10px 15px rgba(255,255,255,0.1); margin-bottom: 25px;">
                        @endif

                        <h2 style="color: #ffffff; font-size: 26px; margin: 0 0 10px 0;">{{ $movie->title }}</h2>
                        <p style="color: #eab308; font-weight: bold; margin-bottom: 20px;">{{ $movie->year }}</p>

                        <p style="color: #9ca3af; font-size: 15px; line-height: 1.6; margin-bottom: 30px; text-align: left;">
                            {{ Str::limit($movie->description, 150) }}
                        </p>

                        <a href="{{ route('user.movies.show', $movie->id) }}" style="border: 2px solid #eab308; color: #eab308; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block;">
                            Ver Ficha Completa
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
