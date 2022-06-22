<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function create(Request $request)
    {

        dd($request);
        $role = Role::create([

        ]);
    }
}
