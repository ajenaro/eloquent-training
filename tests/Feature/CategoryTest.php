<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_category_has_many_posts()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $firstPost = factory(Post::class)->create([
            'author_id' => $user->id
        ]);
        $secondPost = factory(Post::class)->create([
           'author_id' => $user->id
        ]);

        $category->posts()->attach($firstPost);
        $category->posts()->attach($secondPost);

        $this->assertInstanceOf(BelongsToMany::class, $category->posts());
        $this->assertInstanceOf(Collection::class, $category->posts);
        $this->assertCount(2, $category->posts);

        $posts = $category->posts->all();
        $this->assertTrue(is_array($posts));
        $this->assertTrue($posts[0]->is($firstPost));
        $this->assertTrue($posts[1]->is($secondPost));
    }
}
