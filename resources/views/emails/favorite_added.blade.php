<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="margin: 0; padding: 0; background-color: #16181c; font-family: 'Arial', sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color: #16181c; padding: 40px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="background-color: #000000; border-top: 4px solid #ef4444; border-radius: 8px; overflow: hidden;">
                <tr>
                    <td style="padding: 40px; text-align: center;">
                        <h1 style="font-size: 40px; margin: 0 0 20px 0;">❤️</h1>

                        <h2 style="color: #ffffff; margin-bottom: 10px;">{{ __('¡Guardada en Favoritos!') }}</h2>
                        <p style="color: #9ca3af; margin-bottom: 30px;">
                            {{ __('Has añadido') }} <strong>{{ $movie->title }}</strong> {{ __('a tu lista de favoritos. ¡Tienes buen gusto!') }}
                        </p>

                        <table width="100%" style="background-color: #111; border-radius: 8px; padding: 15px;">
                            <tr>
                                @if($movie->poster)
                                    <td width="60">
                                        <img src="{{ asset('storage/' . $movie->poster) }}" style="width: 50px; border-radius: 4px;">
                                    </td>
                                @endif
                                <td style="color: #fff; font-weight: bold; padding-left: 15px;">
                                    {{ $movie->title }} <span style="color: #666; font-weight: normal; font-size: 12px;">({{ $movie->year }})</span>
                                </td>
                                <td align="right">
                                    <a href="{{ route('user.movies.show', $movie->id) }}" style="color: #eab308; text-decoration: none; font-size: 14px;">{{ __('Ver') }} &rarr;</a>
                                </td>
                            </tr>
                        </table>

                        <p style="margin-top: 30px;">
                            <a href="{{ route('user.favorites') }}" style="color: #9ca3af; text-decoration: underline; font-size: 14px;">{{ __('Ver toda mi lista de favoritos') }}</a>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
