<?php

namespace App\Admin\Users\Controllers;

use App\Admin\Users\Requests\UserStoreRequest;
use App\Http\Controllers\Admin\Controller;;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    //

    public function index()
    {
        $users = User::with('role')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(UserStoreRequest $request){

        $input = $request->validated();
        $input['password'] = bcrypt('defaultpassword');

        User::create($input);

        return redirect()->route('admin.users.create')->with('success', 'User created successfully.');
    }
}
