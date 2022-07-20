<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'isAdmin',

        'canWatchVideos',
        'canCreateVideo',
        'canUpdateVideo',
        'canUpdateOthersVideo',
        'canDeleteVideo',
        'canDeleteOthersVideo',

        'canViewUser',
        'canCreateUser',
        'canUpdateUserSelf',
        'canUpdateUserOther',
        'canDeleteUserSelf',
        'canDeleteUserOther',
        'canUpdateUserRole',

        'canViewRoles',
        'canCreateRole',
        'canUpdateRole',
        'canDeleteRole',

        'canViewComments',
        'canCreateComment',
        'canUpdateCommentSelf',
        'canUpdateCommentOther',
        'canDeleteCommentSelf',
        'canDeleteCommentOther'
    ];

    public function level()
    {
        return $this->canUpdate + $this->canCreate + $this->canComment + $this->canDeleteVid + $this->canDeleteCom + $this->CanBanUser . '/6';
    }

    public function id64() {
        return base64_encode($this->id);
    }

    public function userCount() {
        return $this->users()->count();
    }

    public function users() {
        return $this->hasMany(User::class);
    }

    public function levelVideo()
    {
        $level = ($this->canWatchVideos + $this->canCreateVideo + $this->canUpdateVideo + $this->canDeleteVideo + $this->canDeleteOthersVideo + $this->canUpdateOthersVideo) / 6;
        if ($level == 1) {
            return array(
                'text' => 'Full',
                'color' => 'red'
            );
        } elseif ($level > 0.5) {
            return array(
                'text' => 'Half',
                'color' => 'orange'
            );
        } else {
            return array(
                'text' => 'Default',
                'color' => 'grey'
            );
        }
    }

    public function levelUser()
    {
        $level = ($this->canViewUser + $this->canCreateUser + $this->canUpdateUserSelf + $this->canUpdateUserOther + $this->canDeleteUserSelf + $this->canDeleteUserOther + $this->canUpdateUserRole) / 7;
        if ($level == 1) {
            return array(
                'text' => 'Full',
                'color' => 'red'
            );
        } elseif ($level > 0.5) {
            return array(
                'text' => 'Half',
                'color' => 'orange'
            );
        } else {
            return array(
                'text' => 'Default',
                'color' => 'grey'
            );
        }

    }

    public function levelRole()
    {
        $level = ($this->canViewRoles + $this->canCreateRole + $this->canUpdateRole + $this->canDeleteRole) / 4;
        if ($level == 1) {
            return array(
                'text' => 'Full',
                'color' => 'red'
            );
        } elseif ($level > 0.5) {
            return array(
                'text' => 'Half',
                'color' => 'orange'
            );
        } else {
            return array(
                'text' => 'Default',
                'color' => 'grey'
            );
        }

    }

    public function levelComment()
    {
        $level = ($this->canViewComments + $this->canCreateComment + $this->canUpdateCommentSelf + $this->canUpdateCommentOther + $this->canDeleteCommentSelf + $this->canDeleteCommentOther) / 6;
        if ($level == 1) {
            return array(
                'text' => 'Full',
                'color' => 'red'
            );
        } elseif ($level > 0.5) {
            return array(
                'text' => 'Half',
                'color' => 'orange'
            );
        } else {
            return array(
                'text' => 'Default',
                'color' => 'grey'
            );
        }
    }
}
