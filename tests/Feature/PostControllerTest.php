<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows authenticated user to create a post', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('posts.store'), [
        'title' => 'New Post',
        'content' => 'Post content',
    ]);

    $response->assertRedirect(route('posts.index'));
    $this->assertDatabaseHas('posts', [
        'title' => 'New Post',
        'user_id' => $user->id,
    ]);
});

it('shows posts for authenticated user', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $this->actingAs($user);

    $response = $this->get(route('posts.index'));

    $response->assertStatus(200);
    $response->assertSee($post->title);
});

it('prevents unauthorized access', function () {
    $response = $this->get(route('posts.index'));
    $response->assertRedirect(route('login'));
});
