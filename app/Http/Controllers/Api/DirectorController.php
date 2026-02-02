<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\Controller;
use App\Models\Director;
use App\Http\Resources\DirectorResource;
use Illuminate\Http\Request;
use App\Events\DirectorCreated;
use App\Jobs\SyncExternalData;

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
        $val = $request->validate(['name' => 'required']);
        $director = Director::create($val);

        //Job
        SyncExternalData::dispatch();
        // Evento
        DirectorCreated::dispatch($director);

        return response()->json($director, 201);
    }
}
