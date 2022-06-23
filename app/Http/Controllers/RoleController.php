<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function create(Request $request)
    {
        dd($request->input('canUpdate'));

        $role = Role::create([
            'name' => $request->input('name'),
            'canUpdate'     => $request->input('canUpdate') === null ? 1 : 0,
            'canCreate'     => $request->input('canCreate'),
            'canComment'    => $request->input('canComment'),
            'canDeleteVid'  => $request->input('canDeleteVid'),
            'canDeleteCom'  => $request->input('canDeleteCom'),
            'CanBanUser'    => $request->input('CanBanUser'),
        ]);
    }
}
