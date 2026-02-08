<?php

namespace App\Http\Controllers\Api;

use App\Events\DirectorCreated;
use App\Http\Controllers\Admin\Controller;
use App\Jobs\AuditLogJob;
use App\Models\Director;
use App\Http\Resources\DirectorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DirectorController extends Controller
{
    public function index()
    {
        return DirectorResource::collection(Director::all());
    }

    public function show(Director $director)
    {
        return new DirectorResource($director);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Director::class);

        $validated = $request->validate(['name' => 'required|string|max:255']);
        $director = Director::create($validated);

        //Job y Event
        DirectorCreated::dispatch($director);
        AuditLogJob::dispatch("API: Director '{$director->name}' creado por " . $request->user()->email);

        return new DirectorResource($director);
    }

    public function update(Request $request, Director $director)
    {
        Gate::authorize('update', $director);

        $validated = $request->validate(['name' => 'required|string|max:255']);
        $director->update($validated);

        AuditLogJob::dispatch("API: Director '{$director->name}' actualizado por " . $request->user()->email);
        return new DirectorResource($director);
    }

    // Añadimos Request $request en los paréntesis
    public function destroy(Request $request, Director $director)
    {
        Gate::authorize('delete', $director);

        $name = $director->name;

        $director->delete();

        AuditLogJob::dispatch("API: Director '$name' eliminado por " . $request->user()->email);

        return response()->json(['message' => 'Director eliminado'], 204);
    }
}
