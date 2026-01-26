<?php

namespace App\Admin\Users\Controllers\Auth;

use App\Http\Controllers\Admin\Controller;
use App\Models\User;
use App\Models\Role; // Importamos el modelo Role
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 1. Crear Usuario
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 2. Asignar Rol (Si es Juan -> Admin, si no -> User)
        $nombreRol = ($request->email === 'juan@admin.es') ? 'admin' : 'user';
        $rol = Role::where('name', $nombreRol)->first();

        if ($rol) {
            $user->role_id = $rol->id;
            $user->save();
        }

        event(new Registered($user));

        Auth::login($user);

        // 3. Redirigir
        // Si por casualidad se registra Juan, lo mandamos al admin dashboard.
        // Si es Pepe, al user dashboard.
        if ($user->email === 'juan@admin.es') {
            return redirect(route('admin.dashboard', absolute: false));
        }

        return redirect(route('user.movies.index', absolute: false));
    }
}
