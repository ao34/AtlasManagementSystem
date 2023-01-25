<?php

use Illuminate\Database\Seeder;
use App\Models\Posts\Post;


class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'user_id' => '1',
            'post_title' => 'テスト投稿',
            'post' => 'テスト投稿。',
        ]);
    }
}
