<?php

use App\Models\User;
use Illuminate\Auth\SessionGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the login page renders for guests', function () {
    $this->get(route('show.login'))->assertOk();
});

test('a user can log in with valid credentials', function () {
    $user = User::factory()->create();

    $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password', // UserFactory's default password
    ])->assertRedirect(route('projects.index'));

    $this->assertAuthenticatedAs($user);
});

test('a user is sent back to the page they originally requested after logging in', function () {
    $user = User::factory()->create();

    $this->get(route('media.index'))->assertRedirect(route('show.login'));

    $this->post(route('login'), ['email' => $user->email, 'password' => 'password'])
        ->assertRedirect(route('media.index'));
});

test('a user cannot log in with a wrong password', function () {
    $user = User::factory()->create();

    $this->post(route('login'), ['email' => $user->email, 'password' => 'wrong'])
        ->assertSessionHasErrors('credentials');

    $this->assertGuest();
});

test('"keep me signed in" sets a remember cookie', function () {
    $user = User::factory()->create();

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
        'remember' => 'on',
    ]);

    // The session guard names its remember-me cookie "remember_web_<hash>"
    $response->assertCookie('remember_web_' . sha1(SessionGuard::class));
});

test('login is locked after too many failed attempts', function () {
    $this->freezeTime(); // so the "60 seconds" in the message can't tick down to 59 mid-test
    $user = User::factory()->create();

    for ($i = 0; $i < 5; $i++) {
        $this->post(route('login'), ['email' => $user->email, 'password' => 'wrong']);
    }

    // Even the correct password is refused while locked out
    $this->post(route('login'), ['email' => $user->email, 'password' => 'password'])
        ->assertSessionHasErrors(['credentials' => 'Too many login attempts. Please try again in 60 seconds.']);

    $this->assertGuest();
});

test('a user can log out', function () {
    $this->actingAs(User::factory()->create())
        ->post(route('logout'))
        ->assertRedirect(route('show.login'));

    $this->assertGuest();
});
