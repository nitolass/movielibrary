<?php

use App\Models\User;
use App\Models\Movie;
use App\Mail\FavoriteAddedMail;
use App\Mail\NewMovieMail;
use App\Mail\VerifyAccountMail;
use App\Mail\WatchLaterAddedMail;
use App\Mail\WelcomeUserMail;

// 1. Test del Email de BIENVENIDA
test('el email de bienvenida se renderiza correctamente', function () {
    $user = User::factory()->make([
        'name' => 'Usuario Pest',
        'email' => 'pest@test.com'
    ]);

    $mail = new WelcomeUserMail($user);

    // Verificamos que el HTML contenga el nombre y textos clave
    $mail->assertSeeInHtml('Usuario Pest');
    $mail->assertSeeInHtml('Bienvenido');

    // Verificamos el Asunto
    $mail->assertHasSubject('Bienvenido a MovieApp - Activa tu cuenta');
});

// 2. Test del Email de VERIFICACIÓN
test('el email de verificación se renderiza correctamente', function () {
    $user = User::factory()->make(['name' => 'Ana Pest']);

    $mail = new VerifyAccountMail($user);

    $mail->assertSeeInHtml('Ana Pest');
    $mail->assertSeeInHtml('Confirmar mi cuenta');
    $mail->assertHasSubject('Verifica tu correo electrónico');
});

// 3. Test del Email de NUEVA PELÍCULA
test('el email de nueva película muestra el título y año', function () {
    // Asignamos ID manual porque la vista usa route()
    $movie = Movie::factory()->make([
        'id' => 1,
        'title' => 'Dune 2',
        'year' => 2024,
        'description' => 'Arena y gusanos.',
    ]);

    $mail = new NewMovieMail($movie);

    $mail->assertSeeInHtml('Dune 2');
    $mail->assertSeeInHtml('2024');
    $mail->assertHasSubject('¡Estreno! Nueva película: Dune 2');
});

// 4. Test del Email de FAVORITOS
test('el email de favoritos se renderiza correctamente', function () {
    $movie = Movie::factory()->make([
        'id' => 1,
        'title' => 'Inception'
    ]);

    $mail = new FavoriteAddedMail($movie);

    $mail->assertSeeInHtml('Inception');
    $mail->assertSeeInHtml('¡Guardada en Favoritos!');
    $mail->assertHasSubject(' Nueva película favorita: Inception');
});

// 5. Test del Email de VER MÁS TARDE
test('el email de ver más tarde se renderiza correctamente', function () {
    $movie = Movie::factory()->make([
        'id' => 1,
        'title' => 'Matrix'
    ]);

    $mail = new WatchLaterAddedMail($movie);

    $mail->assertSeeInHtml('Matrix');
    $mail->assertSeeInHtml('¡Guardada para después!');
    $mail->assertHasSubject('Guardada para ver más tarde: Matrix');
});
