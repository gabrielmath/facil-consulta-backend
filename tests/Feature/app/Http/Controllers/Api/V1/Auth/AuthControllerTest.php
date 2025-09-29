<?php

use App\Models\User;

it('should users can authenticate', function () {
    $user = User::factory()->create();

    $response = $this->post('api/v1/login', [
        'email'    => $user->email,
        'password' => 'password'
    ]);

    $this->assertAuthenticated();

    $response->assertOk();
});

it('users should not be able to authenticate with invalid password', function () {
    $user = User::factory()->create();

    $response = $this->post('api/v1/login', [
        'email'    => $user->email,
        'password' => 'wrong-password'
    ]);

    $this->assertGuest();

    $response->assertUnauthorized();
});

it('users should not be able to authenticate without the email', function () {
    $this->postJson('api/v1/login', [
        'email'    => '',
        'password' => 'password'
    ])
        ->assertInvalid(['email'])
        ->assertUnprocessable();
});

it('users should not be able to authenticate without the password', function () {
    $user = User::factory()->create();

    $this->postJson('api/v1/login', [
        'email'    => $user->email,
        'password' => ''
    ])
        ->assertInvalid(['password'])
        ->assertUnprocessable();
});

it('should users can logout', function () {
    $user = User::factory()->create();

    $this->post('api/v1/login', [
        'email'    => $user->email,
        'password' => 'password'
    ]);

    $this->assertAuthenticated();

    $response = $this->get('/api/v1/logout');
    $response->assertNoContent();
});

it('users should not logout if they are not logged in', function () {
    $this
        ->getJson('/api/v1/logout')
        ->assertJson(['message' => 'Unauthenticated.'])
        ->assertUnauthorized();
});
