<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Spatie\Permission\Models\Role;

test('it allows authenticated user to create a post', function () {
    Role::firstOrCreate(['name' => 'admin']);
    $user = User::factory()->create(['password' => bcrypt('password')]);
    $user->assignRole('admin');

    $category = Category::factory()->create();

    $this->actingAs($user);

    $response = $this->post(route('posts.store'), [
        'title' => 'New Post',
        'content' => 'Post content',
        'status' => 'draft',
        'category_id' => $category->id,
    ]);

    $response->assertRedirect(route('posts.index'));
    $this->assertDatabaseHas('posts', [
        'title' => 'New Post',
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);
});