<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Video;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @param \App\Models\Video  $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function watch(User $user, Video $video)
    {
        if ($user->role()->is_admin) {
            return true;
        } else if ($user->role()->canWatchVideos) {
            if ($video->type == 'private') {
                return $user->id == $video->user_id;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role()->canCreateVideo;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Video $video)
    {
        if ($video->user_id == $user->id) {
            return $user->role()->canUpdateVideo;
        } else {
            return $user->role()->canUpdateOthersVideo;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Video $video)
    {
        if ($video->user_id == $user->id) {
            return $user->role()->canDeleteVideo;
        } else {
            return $user->role()->canDeleteOthersVideo;
        }
    }
}
