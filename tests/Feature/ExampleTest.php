<?php

use App\Models\Benefit;
use App\Models\Image;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests are redirected to the login page', function () {
    $this->get('/')->assertRedirect(route('show.login'));
});

test('authenticated users can view every dashboard page', function (string $url) {
    Image::factory()->create();
    Benefit::factory()->create();
    Testimonial::factory()->create();

    $this->actingAs(User::factory()->create())
        ->get($url)
        ->assertOk();
})->with([
    'home' => '/',
    'projects' => '/projects',
    'portfolio' => '/projects/portfolio',
    'benefits' => '/projects/portfolio/benefits',
    'testimonials' => '/projects/portfolio/testimonials',
    'media' => '/media',
]);
