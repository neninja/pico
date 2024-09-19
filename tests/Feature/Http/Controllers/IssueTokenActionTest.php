<?php

use App\Models\User;

test('issue a token', function () {
    $password = fake()->password();
    $user = User::factory()->create([
        'email' => fake()->email(),
        'password' => $password,
    ]);

    $this->post('/api/auth', [
        'email' => $user->email,
        'password' => $password,
    ])
        ->assertSuccessful()
        ->assertJsonStructure([
            'access_token',
            'expires_at',
        ]);
});

test('throws error with invalida credentials', function () {
    $user = User::factory()->create([
        'email' => fake()->email(),
        'password' => fake()->password,
    ]);

    $this->post('/api/auth', [
        'email' => $user->email,
        'password' => 'senhaerrada',
    ])->assertForbidden();
});
