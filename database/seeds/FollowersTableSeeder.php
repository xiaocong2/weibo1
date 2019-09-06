<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $users = User::all();
       $user  = $users->first();
       $user_id = $user->id;

       //获取去除掉ID为1的所有用户ID数组
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        //关注除了ID为1用户以外的所有用户
        $user->follow($follower_ids);

        //除了ID为1以外的所有用户都来关注ID为1的用户
        foreach ($followers as $follower){
            $follower->follow($user_id);
        }
    }
}
