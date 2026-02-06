<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreActorRequest;
use App\Http\Requests\UpdateActorRequest;
use App\Jobs\AuditLogJob;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate; // <--- Importante

class ActorController
{
    public function index()
    {
        Gate::authorize('viewAny', Actor::class);
        $actors = Actor::paginate(10);
        return view('admin.actors.index', compact('actors'));
    }

    public function create()
    {
        Gate::authorize('create', Actor::class);
        return view('admin.actors.create');
    }

    public function store(StoreActorRequest $request)
    {
        Gate::authorize('create', Actor::class);
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('actors', 'public');
        }

        $actor = Actor::create($data);

        //Job
        AuditLogJob::dispatch("ACTOR: Se ha creado el actor '{$actor->name}'");

        return redirect()->route('actors.index')->with('success', 'Actor creado correctamente.');
    }

    public function show(Actor $actor)
    {
        Gate::authorize('view', $actor);
        return view('admin.actors.show', compact('actor'));
    }

    public function edit(Actor $actor)
    {
        Gate::authorize('update', $actor);
        return view('admin.actors.edit', compact('actor'));
    }

    public function update(UpdateActorRequest $request, Actor $actor)
    {
        Gate::authorize('update', $actor);
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('actors', 'public');
        }

        $actor->update($data);
        //Job
        AuditLogJob::dispatch("ACTOR: Se ha actualizado el actor '{$actor->name}'");
        return redirect()->route('actors.index')->with('success', 'Actor actualizado correctamente.');
    }

    public function destroy(Actor $actor)
    {
        Gate::authorize('delete', $actor);
        $actor->delete();
        AuditLogJob::dispatch("ACTOR: Se ha eliminado el actor '{$actor->name}'");
        return redirect()->route('actors.index')->with('success', 'Actor eliminado correctamente.');
    }
}
