<?php

use App\Admin\Users\Requests\UserStoreRequest;
use Illuminate\Support\Facades\Validator;

test('user store request internal validation', function () {
    $request = new UserStoreRequest();

    // Esto fuerza a leer el método authorize()
    expect($request->authorize())->toBeTrue();

    // Esto fuerza a leer el método rules()
    $rules = $request->rules();

    $validator = Validator::make([
        'email' => 'test@test.com',
        'name' => 'John',
        'surname' => 'Doe',
        'role_id' => 1,
        'password' => '12345678'
    ], $rules);

    expect($rules)->toHaveKeys(['email', 'name', 'surname', 'role_id', 'password']);
    expect($validator->passes())->toBeTrue();
});
