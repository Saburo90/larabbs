<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategorysData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name' => '分享',
                'description' => '分享创造，分享发现',
            ],

            [
                'name' => '教程',
                'description' => '开发技巧，推荐扩展包等',
            ],

            [
                'name' => '问答',
                'description' => '请保持友善，互帮互助',
            ],

            [
                'name' => '公告',
                'description' => '站点公告',
            ],
        ];

        // 插入初始化分类数据
        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 清空初始化数据
        DB::table('categories')->truncate();
    }
}
