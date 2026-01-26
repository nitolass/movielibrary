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

    public function store(Request $request)
    {
        // 1. Validar
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        // 2. Crear Usuario
        User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        // 3. Redirigir
        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente');
    }
    public function show(User $user)
    {
        $user->load('watchLater');

        return view('admin.users.show', compact('user'));
    }
}
