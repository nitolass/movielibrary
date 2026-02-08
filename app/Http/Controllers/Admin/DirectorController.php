<?php

namespace App\Http\Controllers\Admin;

use App\Events\DirectorCreated;
use App\Http\Requests\DirectorRequest;
use App\Jobs\AuditLogJob;
use App\Models\Director;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class DirectorController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Director::class);
        $directors = Director::all();
        return view('admin.directors.index', compact('directors'));
    }

    public function create()
    {
        Gate::authorize('create', Director::class);
        return view('admin.directors.create');
    }

    public function store(DirectorRequest $request)
    {
        Gate::authorize('create', Director::class);
        $data = $request->validated();


        if($request->hasFile('photo')){
            $data['photo'] = $request->file('photo')->store('directors','public');
        }

        $director = Director::create($data);
        //Job y event
        DirectorCreated::dispatch($director);
        AuditLogJob::dispatch("DIRECTOR: Se ha creado el director '{$director->name}'");
        return redirect()->route('directors.index')->with('success', 'Director creado correctamente');
    }

    public function show(Director $director)
    {
        Gate::authorize('view', $director);
        return view('admin.directors.show', compact('director'));
    }

    public function edit(Director $director)
    {
        Gate::authorize('update', $director);
        return view('admin.directors.edit', compact('director'));
    }

    public function update(DirectorRequest $request, Director $director)
    {
        Gate::authorize('update', $director);
        $data = $request->validated();

        if($request->hasFile('photo')){
            if($director->photo){
                Storage::disk('public')->delete($director->photo);
            }
            $data['photo'] = $request->file('photo')->store('directors','public');
        }

        $director->update($data);
        //Job
        AuditLogJob::dispatch("DIRECTOR: Se ha actualizado el director '{$director->name}'");
        return redirect()->route('directors.index')->with('success', 'Director actualizado correctamente');
    }

    public function destroy(Director $director)
    {
        Gate::authorize('delete', $director);

        if($director->photo){
            Storage::disk('public')->delete($director->photo);
        }
        $director->delete();
        //Job
        AuditLogJob::dispatch("DIRECTOR: Se ha eliminado el director '{$director->name}'");
        return redirect()->route('directors.index')->with('success', 'Director eliminado correctamente');
    }
}
