<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "城南ゼミナール";
        $user->email = "1@gmail.com";
        //パスワードを保存する場合はbcrypt()で暗号化する。
        $user->password = bcrypt("11111111");
        $user->save();

        $user = new User();
        $user->name = "城北塾";
        $user->email = "2@gmail.com";
        //パスワードを保存する場合はbcrypt()で暗号化する。
        $user->password = bcrypt("22222222");
        $user->save();

    }
}
