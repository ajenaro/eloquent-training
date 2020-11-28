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
}
