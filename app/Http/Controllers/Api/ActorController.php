<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\Controller;
use App\Http\Resources\ActorResource;
use App\Models\Actor;
use Illuminate\Http\Request;
use App\Events\ActorCreated;
use App\Jobs\AuditLogJob;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actors= Actor::with('movies')->get();
        return ActorResource::collection($actors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string']);

        $actor = Actor::create($validated);
        //Job
        AuditLogJob::dispatch("Creación de actor: {$actor->name}");

        ActorCreated::dispatch($actor);

        return response()->json($actor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $actor)
    {
        return new ActorResource($actor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
