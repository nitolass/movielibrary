<?php

namespace App\Http\Controllers\Api;

use App\Admin\Users\Requests\UserStoreRequest;
use App\Http\Controllers\Admin\Controller;
use App\Jobs\AuditLogJob;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        // Policy: viewAny (Solo Admin)
        Gate::authorize('viewAny', User::class);

        $users = User::with('role')->paginate(10);
        return UserResource::collection($users);
    }

    public function store(UserStoreRequest $request)
    {
        // Policy: create (Solo Admin)
        Gate::authorize('create', User::class);

        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        AuditLogJob::dispatch("API: Usuario '{$user->email}' creado por Admin " . $request->user()->email);
        return new UserResource($user);
    }

    public function show(User $user)
    {
        // Policy: view (Admin o el propio usuario)
        Gate::authorize('view', $user);

        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        // Policy: update (Admin o el propio usuario)
        Gate::authorize('update', $user);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'sometimes|string|min:8',
            'role_id' => 'sometimes|exists:roles,id' // Cuidado: un usuario normal no debería poder cambiar su rol
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Seguridad extra: Si intentan cambiar role_id y NO es admin, lo ignoramos o lanzamos error.
        // Asumiendo que tu UserPolicy solo deja editar al propio usuario si no es admin:
        if ($request->has('role_id') && $request->user()->role->name !== 'admin') {
            return response()->json(['message' => 'No puedes cambiar tu rol'], 403);
        }

        $user->update($validated);

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $email = $user->email;
        // Policy: delete (Solo Admin o cuenta propia)
        Gate::authorize('delete', $user);

        $user->delete();
        AuditLogJob::dispatch("API: Usuario '$email' eliminado por Admin " . Auth::user()->email);
        return response()->json(['message' => 'Usuario eliminado'], 204);
    }
}
