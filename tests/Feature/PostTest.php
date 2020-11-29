<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_post_belongs_to_an_author()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'author_id' => $user->id
        ]);

        $this->assertInstanceOf(BelongsTo::class, $post->author());
        $this->assertInstanceOf(User::class, $post->author);
        $this->assertTrue($post->author->is($user));
    }

    /** @test */
    function a_post_belongs_to_many_categories()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'author_id' => $user->id
        ]);

        $eloquent = factory(Category::class)->create([
            'title' => 'Eloquent'
        ]);

        $laravel = factory(Category::class)->create([
            'title' => 'Laravel'
        ]);

        $php = factory(Category::class)->create([
            'title' => 'PHP'
        ]);

        $post->categories()->sync($eloquent);
        $post->addCategories($laravel, $php);

        $this->assertInstanceOf(BelongsToMany::class, $post->categories());
        $this->assertInstanceOf(Collection::class, $post->categories);

        $this->assertCount(3, $post->categories);

        $this->assertSame(['Eloquent', 'Laravel', 'PHP'], $post->categories->pluck('title')->all());
    }

    /** @test */
    function posts_without_an_author_are_assigned_a_default_author()
    {
        $post = factory(Post::class)->create([
            'author_id' => null
        ]);

        $this->assertInstanceOf(BelongsTo::class, $post->author());
        $this->assertInstanceOf(User::class, $post->author);
        $this->assertFalse($post->author->exists);
        $this->assertSame('Styde', $post->author->name);
    }
}
