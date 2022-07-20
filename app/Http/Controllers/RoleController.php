<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function create()
    {
        return view('role.create');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
        ]);

        $role = Role::create(
            [
                'name' => $request->name,
                'isAdmin' => $request->isAdmin ? 1 : 0,

                'canWatchVideos' => $request->canWatchVideos ? 1 : 0,
                'canCreateVideo' => $request->canCreateVideo ? 1 : 0,
                'canUpdateVideo' => $request->canUpdateVideo ? 1 : 0,
                'canUpdateOthersVideo' => $request->canUpdateOthersVideo ? 1 : 0,
                'canDeleteVideo' => $request->canDeleteVideo ? 1 : 0,
                'canDeleteOthersVideo' => $request->canDeleteOthersVideo ? 1 : 0,

                'canViewUser' => $request->canViewUser ? 1 : 0,
                'canCreateUser' => $request->canCreateUser ? 1 : 0,
                'canUpdateUserSelf' => $request->canUpdateUserSelf ? 1 : 0,
                'canUpdateUserOther' => $request->canUpdateUserOther ? 1 : 0,
                'canDeleteUserSelf' => $request->canDeleteUserSelf ? 1 : 0,
                'canDeleteUserOther' => $request->canDeleteUserOther ? 1 : 0,
                'canUpdateUserRole' => $request->canUpdateUserRole ? 1 : 0,

                'canViewRoles' => $request->canViewRoles ? 1 : 0,
                'canCreateRole' => $request->canCreateRole ? 1 : 0,
                'canUpdateRole' => $request->canUpdateRole ? 1 : 0,
                'canDeleteRole' => $request->canDeleteRole ? 1 : 0,

                'canViewComments' => $request->canViewComments ? 1 : 0,
                'canCreateComment' => $request->canCreateComment ? 1 : 0,
                'canUpdateCommentSelf' => $request->canUpdateCommentSelf ? 1 : 0,
                'canUpdateCommentOther' => $request->canUpdateCommentOther ? 1 : 0,
                'canDeleteCommentSelf' => $request->canDeleteCommentSelf ? 1 : 0,
                'canDeleteCommentOther' => $request->canDeleteCommentOther ? 1 : 0,
            ]
        );

        return redirect()->route('admin.roles');
    }

    public function update(Request $request, $role)
    {
        $role = Role::find(base64_decode($role));

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role = Role::find($role->id);
        $role->name = $request->name;
        $role->isAdmin = $request->isAdmin ? 1 : 0;

        $role->canWatchVideos = $request->canWatchVideos ? 1 : 0;
        $role->canCreateVideo = $request->canCreateVideo ? 1 : 0;
        $role->canUpdateVideo = $request->canUpdateVideo ? 1 : 0;
        $role->canUpdateOthersVideo = $request->canUpdateOthersVideo ? 1 : 0;
        $role->canDeleteVideo = $request->canDeleteVideo ? 1 : 0;
        $role->canDeleteOthersVideo = $request->canDeleteOthersVideo ? 1 : 0;

        $role->canViewUser = $request->canViewUser ? 1 : 0;
        $role->canCreateUser = $request->canCreateUser ? 1 : 0;
        $role->canUpdateUserSelf = $request->canUpdateUserSelf ? 1 : 0;
        $role->canUpdateUserOther = $request->canUpdateUserOther ? 1 : 0;
        $role->canDeleteUserSelf = $request->canDeleteUserSelf ? 1 : 0;
        $role->canDeleteUserOther = $request->canDeleteUserOther ? 1 : 0;
        $role->canUpdateUserRole = $request->canUpdateUserRole ? 1 : 0;

        $role->canViewRoles = $request->canViewRoles ? 1 : 0;
        $role->canCreateRole = $request->canCreateRole ? 1 : 0;
        $role->canUpdateRole = $request->canUpdateRole ? 1 : 0;
        $role->canDeleteRole = $request->canDeleteRole ? 1 : 0;

        $role->canViewComments = $request->canViewComments ? 1 : 0;
        $role->canCreateComment = $request->canCreateComment ? 1 : 0;
        $role->canUpdateCommentSelf = $request->canUpdateCommentSelf ? 1 : 0;
        $role->canUpdateCommentOther = $request->canUpdateCommentOther ? 1 : 0;
        $role->canDeleteCommentSelf = $request->canDeleteCommentSelf ? 1 : 0;
        $role->canDeleteCommentOther = $request->canDeleteCommentOther ? 1 : 0;

        $role->save();

        return redirect()->route('admin.role.select', $role->id64());
    }

    public function delete($role)
    {
        $role = Role::find(base64_decode($role));

        if (Auth::user()->role()->id == $role->id) {
            return redirect()->route('admin.roles')->withErrors(['You cannot delete your own role.']);
        } else if ($role->userCount() > 0) {
            return redirect()->route('admin.roles')->withErrors(['You cannot delete a role that has still ' . $role->userCount() . ' users.']);
        }

        else if (Auth::user()->role()->canDeleteRole) {
            $role->delete();
            return redirect()->route('admin.roles');
        } else {
            return redirect()->route('admin.roles')->withErrors(['You do not have permission to delete roles.']);
        }
    }
}
