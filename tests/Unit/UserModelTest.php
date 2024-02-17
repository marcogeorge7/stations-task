<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('the user can register', function () {

    // Send a request with prepared data.
    $response = $this->post(route('auth.register'), [
        'email' => "marco@g.com",
        'password' => "password",
        'name' => 'test',
    ]);

    // Check that response has a "200" status.
    $response->assertStatus(Response::HTTP_OK);

    // Check that response structure.
//    $response->assertJsonStructure(['access_token']);
});

test('the user can login', function () {
    // Create a user with a specific email address.
    User::factory()->create([
        'email' => "marco@g.com",
        'password' => Hash::make("password"),
    ]);

    // Send a request with prepared data.
    $response = $this->post(route('auth.login'), [
        'email' => "marco@g.com",
        'password' => "password",
    ]);

    // Check that response has a "200" status.
    $response->assertStatus(Response::HTTP_OK);

    // Check that response structure.
    $response->assertJsonStructure(['access_token']);
});

test('the user can logout', function () {
    // Create a user with a specific email address.
    $user = User::factory()->create([
        'email' => "marco@g.com",
        'password' => Hash::make("password"),
    ]);


    // Send a request with prepared data.
    $response = $this->actingAs($user)->post(route('auth.logout'));

    // Check that response has a "200" status.
    $response->assertStatus(Response::HTTP_OK);
});
