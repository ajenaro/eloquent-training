<?php

use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::pluck('id');
        $users->each(function ($userId) {
            factory(Post::class)->times(rand(1, 10))->create([
                  'author_id' => $userId,
              ]);
        });
    }
}
