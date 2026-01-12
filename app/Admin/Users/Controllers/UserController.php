<?php

namespace App\Admin\Users\Controllers;

use App\Admin\Users\Requests\UserStoreRequest;
use App\Http\Controllers\Admin\Controller;
use App\Models\User;

class UserController extends Controller
{
    //

    public function index(){

        $users = User::all();

        return view('admin.users.index', array(
            'users' => $users
        ));

    }

    public function create(){

        return view('admin.users.create');
    }

    public function store(UserStoreRequest $request){

        $input = $request->validated();
        $input['password'] = bcrypt('defaultpassword');

        User::create($input);

        return redirect()->route('admin.users.create')->with('success', 'User created successfully.');
    }
}
