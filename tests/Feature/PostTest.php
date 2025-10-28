<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has fillable attributes', function (){
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'title' => 'Test Title',
        'content' => 'Test Content',
        'user_id' => $user->id,
    ]);
    expect($post->title)->toBe('Test Title');
    expect($post->content)->toBe('Test Content');
    expect($post->user_id)->toBeNumeric();
});

it('belongs to a user', function (){
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    expect($post->user)->toBeInstanceOf(User::class);
    expect($post->user->id)->toBe($user->id);
});