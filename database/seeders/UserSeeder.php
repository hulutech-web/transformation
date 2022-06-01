<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->count(5)->create();

        $user = User::find(1);
        $user['name'] = '云神仙';
        $user['email'] = 'divied123@163.com';
        $user['mobile'] = 18090900235;
        $user['password'] = Hash::make('admin888');
        $user->save();
        $user = User::find(2);
        $user['name'] = '财发';
        $user['email'] = 'hanmeimei@163.com';
        $user['mobile'] = 18180191182;
        $user['password'] = Hash::make('admin888');
        $user->save();
        $user = User::find(3);
        $user['name'] = '张三';
        $user['email'] = 'zhangsan@163.com';
        $user['mobile'] = 18090900236;
        $user['password'] = Hash::make('admin888');
        $user->save();

    }
}