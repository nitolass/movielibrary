<?php

namespace App\Admin\Users\Controllers;

use App\Admin\Users\Requests\UserStoreRequest;
use App\Events\UserCreated;
use App\Http\Controllers\Admin\Controller;
use App\Jobs\AuditLogJob;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // <--- Importante para validar email único al editar
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', User::class);
        $users = User::with('role')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        Gate::authorize('create', User::class);
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', User::class);

        // Validar
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        // Crear
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        AuditLogJob::dispatch("USUARIOS: Admin " . Auth::user()->email . " creó al usuario '{$user->email}'");
        UserCreated::dispatch($user);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente');
    }

    public function show(User $user)
    {
        Gate::authorize('view', $user);
        $user->load('watchLater'); // Carga relaciones si es necesario
        return view('admin.users.show', compact('user'));
    }

    // --- MÉTODOS AÑADIDOS PARA QUE PASEN LOS TESTS ---

    public function edit(User $user)
    {
        Gate::authorize('update', $user);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user);

        // Validación
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            // Validamos que el email sea único PERO ignorando el ID del usuario actual
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['nullable', 'confirmed', 'min:8'], // Opcional al editar
        ]);

        // Actualizar datos básicos
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->role_id = $request->role_id;

        // Si mandan password, la actualizamos hasheada
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        AuditLogJob::dispatch("USUARIOS: Admin " . Auth::user()->email . " actualizó al usuario '{$user->email}'");

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $email = $user->email; // Guardamos email para el log antes de borrar
        $user->delete();

        AuditLogJob::dispatch("USUARIOS: Admin " . Auth::user()->email . " eliminó al usuario '{$email}'");

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente');
    }
}
