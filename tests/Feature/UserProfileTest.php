<?php

namespace Tests\Feature;

use App\User;
use App\UserProfile;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_profile_belongs_to_a_user()
    {
        $user = factory(User::class)->create();
        $userProfile = factory(UserProfile::class)->create([
           'website' => 'https://styde.net',
           'user_id' => $user->id,
       ]);

        $this->assertInstanceOf(BelongsTo::class, $userProfile->user());
        $this->assertInstanceOf(User::class, $userProfile->user);
        $this->assertTrue($userProfile->user->is($user));
        $this->assertSame('https://styde.net', $user->profile->website);
    }
}
