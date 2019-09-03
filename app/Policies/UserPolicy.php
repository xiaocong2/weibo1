<?php

/**
 * 用户策略
 */
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * 判断登录用户更改的是不是自己的信息
     * Create a new policy instance.
     *
     * @return void
     */
    public function update(User $currentUser ,User $user)
    {
        return $currentUser->id === $user->id;
    }
}
