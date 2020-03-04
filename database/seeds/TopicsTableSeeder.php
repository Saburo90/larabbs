<?php

use Illuminate\Database\Seeder;
use App\Models\Topic;
use App\Models\User;
use App\Models\Category;

class TopicsTableSeeder extends Seeder
{
    public function run()
    {
        // 获取所有用户ID数组
        $user_ids = User::all()->pluck('id')->toArray();

        // 获取所有帖子分类数组
        $category_ids = Category::all()->pluck('id')->toArray();

        // 获取Faker实例
        $faker = app(Faker\Generator::class);

        $topics = factory(Topic::class)->times(100)->make()->each(function ($topic, $index) use ($faker, $user_ids, $category_ids) {
            // 随机分配一个用户ID给当前帖子
            $topic->user_id = $faker->randomElement($user_ids);
            // 随机分配一个帖子分类ID给当前帖子
            $topic->category_id = $faker->randomElement($category_ids);
        });

        // 数据集合转换为数组插入数据库
        Topic::insert($topics->toArray());
    }

}

