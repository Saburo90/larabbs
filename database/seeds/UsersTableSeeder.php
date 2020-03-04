<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        // 头像假数据
        $avatars = [
            'http://www.larabbs.com/images/s5ehp11z6s.png',
            'http://www.larabbs.com/images/Lhd1SHqu86.png',
            'http://www.larabbs.com/images/LOnMrqbHJn.png',
            'http://www.larabbs.com/images/xAuDMxteQy.png',
            'http://www.larabbs.com/images/ZqM7iaP4CR.png',
            'http://www.larabbs.com/images/NDnzMutoxX.png',
        ];

        // 生成数据集合
        $users = factory(User::class)->times(10)->make()->each(function ($user, $index) use ($faker, $avatars) {
            // 从头像假数据数组中随机选取一个赋值当前用户
            $user->avatar = $faker->randomElement($avatars);
        });

        // 让隐藏字段可见
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // 将组装好的假数据插入数据库
        User::insert($user_array);

        // 单独处理第1个用户
        $user = User::find(1);
        $user->name = 'larabbs';
        $user->email = 'saburo90@163.com';
        $user->avatar = 'http://www.larabbs.com/uploads/images/avatars/202003/04/1_1583287451_m0CKATAenB.jpg';
        $user->save();
    }
}
