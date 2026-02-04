<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\Controller; // Ojo: Asegúrate de que heredas del correcto
use App\Http\Resources\ActorResource;
use App\Models\Actor;
use Illuminate\Http\Request;
use App\Events\ActorCreated;
use App\Jobs\AuditLogJob;

class ActorController extends Controller
{
    public function index()
    {
        // Paginamos para evitar cargas masivas
        $actors = Actor::with('movies')->paginate(10);
        return ActorResource::collection($actors);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string']);

        $actor = Actor::create($validated);

        // Tus Jobs y Eventos
        AuditLogJob::dispatch("Creación de actor: {$actor->name}");
        ActorCreated::dispatch($actor);

        return response()->json($actor, 201);
    }

    public function show(Actor $actor)
    {
        return new ActorResource($actor);
    }

    public function update(Request $request, Actor $actor)
    {
        $validated = $request->validate(['name' => 'required|string']);
        $actor->update($validated);
        return response()->json($actor);
    }

    public function destroy(Actor $actor)
    {
        $actor->delete();
        return response()->json(null, 204);
    }
}
