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

    /**
     * 判断当前用户拥有管理员权限且删除的用户不是自己时才显示链接
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function destroy(User $currentUser, User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
