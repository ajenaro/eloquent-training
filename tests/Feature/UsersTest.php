<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use App\UserProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_the_user_profile_associated_to_a_user()
    {
        $user = factory(User::class)->create();

        $userProfile = factory(UserProfile::class)->create([
            'user_id' => $user->id,
            'website' => 'antoniojenaro.com'
        ]);

        $this->assertInstanceOf(UserProfile::class, $user->profile);
        $this->assertTrue($userProfile->is($user->profile));
        $this->assertSame('antoniojenaro.com', $user->profile->website);
    }

    /** @test */
    public function a_user_has_many_post()
    {
        $user = factory(User::class)->create();

        $firstPost = $user->posts()->create([
            'title' => 'First Post',
            'content' => 'Content of the first post'
        ]);

        $secondPost = $user->posts()->create([
            'title' => 'Second Post',
            'content' => 'Content of the second post'
        ]);

        $this->assertInstanceOf(HasMany::class, $user->posts());
        $this->assertInstanceOf(Collection::class, $user->posts);
        $this->assertCount(2, $user->posts);

        $posts = $user->posts->all();
        $this->assertTrue(is_array($posts));
        $this->assertTrue($posts[0]->is($firstPost));
        $this->assertTrue($posts[1]->is($secondPost));
    }

    /** @test */
    public function get_the_published_posts_of_a_user()
    {
        $user = factory(User::class)->create();

        $published = factory(Post::class)->create([
            'author_id' => $user->id,
            'published_at' => now()
        ]);

        $draft = factory(Post::class)->create([
              'author_id' => $user->id,
              'published_at' => null
          ]);

        $scheduled = factory(Post::class)->create([
              'author_id' => $user->id,
              'published_at' => now()->addDay()
          ]);

        $this->assertInstanceOf(HasMany::class, $user->posts());
        $this->assertInstanceOf(Collection::class, $user->publishedPosts);
        $this->assertCount(3, $user->posts);
        $this->assertCount(1, $user->publishedPosts);
        $this->assertTrue($user->publishedPosts->first()->is($published));
    }

    /** @test */
    function users_without_profile_are_assigned_a_default_profile()
    {
        $user = factory(User::class)->create([
            'name' => 'Antonio',
        ]);

        $this->assertInstanceOf(UserProfile::class, $user->profile);
        $this->assertFalse($user->profile->exists);
        $this->assertSame('Developer', $user->profile->job_title);
        $this->assertSame('https://styde.net/perfil/antonio', $user->profile->website);
    }
}
