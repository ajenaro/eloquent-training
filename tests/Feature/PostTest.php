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
    public function a_post_belongs_to_an_author()
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
    public function a_post_belongs_to_many_categories()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'author_id' => $user->id
        ]);

        $laravel = factory(Category::class)->create([
            'title' => 'Laravel'
        ]);

        $php = factory(Category::class)->create([
            'title' => 'PHP'
        ]);

        //$post->categories()->sync([$laravel->id, $php->id]);
        $post->addCategories($laravel, $php);

        $this->assertInstanceOf(BelongsToMany::class, $post->categories());
        $this->assertInstanceOf(Collection::class, $post->categories);
        $this->assertCount(2, $post->categories);
        $this->assertSame(['Laravel', 'PHP'], $post->categories->pluck('title')->all());
    }
}
