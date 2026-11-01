<?php

use App\Models\Benefit;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

test('a benefit title is normalized when created', function () {
    $this->post(route('portfolio.benefits.store'), [
        'title' => '  FAST DELIVERY ',
        'description' => 'We ship every week, without exception.',
    ])->assertRedirect(route('portfolio.benefits.index'));

    expect(Benefit::sole()->title)->toBe('Fast delivery');
});

test('a benefit description must be at least 20 characters', function () {
    $this->post(route('portfolio.benefits.store'), [
        'title' => 'Short',
        'description' => 'Too short',
    ])->assertSessionHasErrors('description');
});

test('a testimonial title keeps its original casing', function () {
    $this->post(route('portfolio.testimonials.store'), [
        'firstName' => 'Ada',
        'lastName' => 'Lovelace',
        'title' => 'cTO at Odevo',
        'testimonial' => 'Great to work with.',
    ])->assertRedirect(route('portfolio.testimonials.index'));

    expect(Testimonial::sole()->title)->toBe('CTO at Odevo');
});

test('a testimonial can be updated and deleted', function () {
    $testimonial = Testimonial::factory()->create(['image_id' => null]);

    $this->put(route('portfolio.testimonials.update', $testimonial), [
        'firstName' => 'Grace',
        'lastName' => 'Hopper',
        'title' => 'Rear admiral',
        'testimonial' => 'Updated text.',
    ])->assertRedirect(route('portfolio.testimonials.index'));

    expect($testimonial->fresh()->firstName)->toBe('Grace');

    $this->delete(route('portfolio.testimonials.destroy', $testimonial));

    $this->assertModelMissing($testimonial);
});
