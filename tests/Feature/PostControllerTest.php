<?php

use App\Models\Post;
use App\Models\User;
use Spatie\Permission\Models\Role;

test('it allows authenticated user to create a post', function () {
    $user = User::factory()->create();
    
    // ✅ Assign Role
    Role::firstOrCreate(['name' => 'user']);
    $user->assignRole('user');
    
    $this->actingAs($user);

    $response = $this->post(route('posts.store'), [
        'title' => 'New Post',
        'content' => 'Post content',
        'status' => 'draft',
    ]);

    $response->assertRedirect(route('posts.index'));
    $this->assertDatabaseHas('posts', [
        'title' => 'New Post',
        'user_id' => $user->id,
        'status' => 'draft',
    ]);
});

test('it shows posts for authenticated user', function () {
    $user = User::factory()->create();
    
    // ✅ Assign Role
    Role::firstOrCreate(['name' => 'user']);
    $user->assignRole('user');
    
    $post = Post::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    $response = $this->get(route('posts.index'));

    $response->assertStatus(200);
    $response->assertSee($post->title);
});

test('it prevents unauthorized access', function () {
    $response = $this->get(route('posts.index'));

    $response->assertRedirect('/login');
});
