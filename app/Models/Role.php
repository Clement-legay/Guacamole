<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_admin',

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
        return $this->canUpdate + $this->canCreate + $this->canComment + $this->canDeleteVid + $this->canDeleteCom + $this->CanBanUser;
    }

    public function id() {
        return base64_encode($this->id);
    }
}
