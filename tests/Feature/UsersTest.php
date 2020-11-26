<?php

namespace Tests\Feature;

use App\User;
use App\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
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
}
