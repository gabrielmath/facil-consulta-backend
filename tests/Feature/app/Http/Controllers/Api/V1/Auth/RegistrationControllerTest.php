<?php

use App\Http\Requests\Api\V1\RegistrationRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;


it('should create a user', function () {
    $message = ['message' => 'User created successfully!'];
    $newUser = [
        'name'             => 'Usuário Teste',
        'email'            => 'user@test.com',
        'password'         => '12345678',
        'confirm_password' => '12345678',
    ];

    $response = $this->postJson('/api/v1/register', $newUser);

    $response->assertStatus(Response::HTTP_CREATED)->assertJson($message);
});

it('should not create a duplicate user', function () {
    $newUser = [
        'name'     => 'Usuário Teste',
        'email'    => 'user@test.com',
        'password' => '12345678',
    ];

    $registrationRule = new RegistrationRequest();

    User::create($newUser);

    $this
        ->postJson('/api/v1/register', $newUser)
        ->assertInvalid(['email' => $registrationRule->messages()['email.unique']])
        ->assertUnprocessable();
});

it('should not create a user without a name', function () {
    $newUser = [
        'name'     => '',
        'email'    => 'user@test.com',
        'password' => '12345678',
    ];

    $this
        ->postJson('/api/v1/register', $newUser)
        ->assertInvalid(['name' => trans('validation.required', ['attribute' => 'nome'])])
        ->assertUnprocessable();
});

it('should not create a user without a full name', function () {
    $newUser = [
        'name'     => 'Usuário',
        'email'    => 'user@test.com',
        'password' => '12345678',
    ];

    $this
        ->postJson('/api/v1/register', $newUser)
        ->assertInvalid(['name' => "Informe seu nome completo, exemplo: José da Silva."])
        ->assertUnprocessable();
});

it('should not create a user without a email', function () {
    $newUser = [
        'name'             => 'Usuário Teste',
        'email'            => '',
        'password'         => '12345678',
        'confirm_password' => '12345678',
    ];

    $this
        ->postJson('/api/v1/register', $newUser)
        ->assertInvalid(['email' => trans('validation.required', ['attribute' => 'email'])])
        ->assertUnprocessable();
});

it('should not create a user with invalid email', function () {
    $newUser = [
        'name'             => 'Usuário Teste',
        'email'            => 'test',
        'password'         => '12345678',
        'confirm_password' => '12345678',
    ];

    $this
        ->postJson('/api/v1/register', $newUser)
        ->assertInvalid(['email' => trans('validation.email', ['attribute' => 'email'])])
        ->assertUnprocessable();
});

it('should not create a user with a password shorter than 4 digits', function () {
    $newUser = [
        'name'     => 'Usuário Teste',
        'email'    => 'test@email.com',
        'password' => '123',
    ];

    $this
        ->postJson('/api/v1/register', $newUser)
        ->assertInvalid(['password' => "Deve ter ao menos 4 dígitos"])
        ->assertUnprocessable();
});

it('should not create a user without a password', function () {
    $newUser = [
        'name'     => 'Test User',
        'email'    => 'user@test.com',
        'password' => '',
    ];

    $this
        ->postJson('/api/v1/register', $newUser)
        ->assertInvalid(['password' => trans('validation.required', ['attribute' => 'senha'])])
        ->assertUnprocessable();
});
