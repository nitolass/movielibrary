<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreActorRequest;
use App\Http\Requests\UpdateActorRequest;
use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actors = Actor::paginate(10);
        return view('admin.actors.index', compact('actors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.actors.create');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActorRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('actors', 'public');
        }

        Actor::create($data);

        return redirect()->route('actors.index')->with('success', 'Actor creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Actor $actor)
    {
        return view('admin.actors.show', compact('actor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actor $actor)
    {
        return view('admin.actors.edit', compact('actor'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActorRequest $request, Actor $actor)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('actors', 'public');
        }

        $actor->update($data);

        return redirect()->route('actors.index')->with('success', 'Actor actualizado correctamente.');
    }
    public function destroy(Actor $actor)
    {
        $actor->delete();
        return redirect()->route('actors.index')->with('success', 'Actor eliminado correctamente.');
    }
}
