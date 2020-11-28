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
        $userId = User::first()->id;

        //$users->each(function ($userId) {
            factory(Post::class)->times(2)->create([
                  'author_id' => $userId,
              ]);
        //});
    }
}
