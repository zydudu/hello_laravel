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

         $users = factory(User::class)->times(50)->make();
        User::insert($users->toArray());

        //下面可以改成你自己的信息
        $user = User::find(1);
        $user->name = 'SadCreeper';
        $user->email = '123@qq.com';
        $user->password = bcrypt('123');
$user->activated = true;
$user->is_admin = true;
        $user->save();
       //

    }
}
