<?php

namespace App\Http\Controllers\Api;

use App\Events\ActorCreated;
use App\Http\Controllers\Admin\Controller;
use App\Jobs\AuditLogJob;
use App\Models\Actor;
use App\Http\Resources\ActorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ActorController extends Controller
{
    public function index()
    {
        // RESTAURADO: Usamos la Policy (que ahora devuelve true para invitados)
        Gate::authorize('viewAny', Actor::class);

        $actors = Actor::with('movies')->paginate(10);
        return ActorResource::collection($actors);
    }

    public function show(Actor $actor)
    {
        // RESTAURADO
        Gate::authorize('view', $actor);

        return new ActorResource($actor);
    }

    // ... (El resto de métodos store/update/destroy déjalos igual, ya tenían Gate) ...
    public function store(Request $request)
    {
        Gate::authorize('create', Actor::class);
        $validated = $request->validate(['name' => 'required|string|max:255']);
        $actor = Actor::create($validated);
        ActorCreated::dispatch($actor);
        AuditLogJob::dispatch("API: Actor '{$actor->name}' creado por " . $request->user()->email);
        return new ActorResource($actor);
    }

    public function update(Request $request, Actor $actor)
    {
        Gate::authorize('update', $actor);
        $validated = $request->validate(['name' => 'required|string|max:255']);
        $actor->update($validated);
        AuditLogJob::dispatch("API: Actor '{$actor->name}' editado por " . $request->user()->email);
        return new ActorResource($actor);
    }

    public function destroy(Actor $actor)
    {
        $name = $actor->name;
        Gate::authorize('delete', $actor);
        $actor->delete();
        AuditLogJob::dispatch("API: Actor '$name' eliminado por " . Auth::user()->email);
        return response()->json(['message' => 'Actor eliminado'], 204);
    }
}
