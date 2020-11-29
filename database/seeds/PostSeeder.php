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
            /*factory(Post::class)->times(3)->create([
                    'author_id' => $userId,
                    'published_at' => now()
              ]);*/
        //});

        $post = Post::create([
            'title' => 'Post publicado',
            'content' => 'En este videotutorial...',
            'author_id' => $userId,
            'published_at' => now()
        ]);

        $post = Post::create([
             'title' => 'Post en borrado',
             'content' => 'En este videotutorial...',
             'author_id' => $userId,
             'published_at' => null
         ]);

        $post = Post::create([
             'title' => 'Post destacado publicado',
             'content' => 'En este videotutorial...',
             'author_id' => $userId,
             'featured' => true,
             'published_at' => now()
         ]);

        $post = Post::create([
             'title' => 'Post destacado programado',
             'content' => 'En este videotutorial...',
             'author_id' => $userId,
             'featured' => true,
             'published_at' => now()->addDay()
         ]);
    }
}
