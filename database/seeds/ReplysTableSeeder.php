<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        // 获取Faker实例
        $faker = app(Faker\Generator::class);
        // 获取所有用户ID
        $user_ids = User::all()->pluck('id')->toArray();
        // 获取所有帖子ID
        $topic_ids = Topic::all()->pluck('id')->toArray();

        $replys = factory(Reply::class)->times(1000)->make()->each(function ($reply, $index) use($faker, $user_ids, $topic_ids) {
            // 随机获取一个用户ID赋值给当前回复用户ID字段
            $reply->user_id = $faker->randomElement($user_ids);
            // 随机获取一个帖子ID赋值给当前回复帖子ID字段
            $reply->topic_id = $faker->randomElement($topic_ids);
        });

        Reply::insert($replys->toArray());
    }

}

