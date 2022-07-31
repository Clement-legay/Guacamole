<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->role()->canViewUsers && $user->role()->isAdmin;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role()->canCreateUser && $user->role()->isAdmin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        if ($user->role()->isAdmin) {
            return true;
        } else if ($user->id == $model->id) {
            return $user->role()->canUpdateUserSelf;
        } else {
            return $user->role()->canUpdateUserOther;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        if ($user->role()->isAdmin) {
            return true;
        } else if ($user->id == $model->id) {
            return $user->role()->canDeleteUserSelf;
        } else {
            return $user->role()->canDeleteUserOther;
        }
    }

    /**
     * Determine whether the user can update role.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function roleUpdate(User $user) {
        return $user->role()->canUpdateUserRole && $user->role()->isAdmin;
    }
}
