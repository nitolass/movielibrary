<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\Controller;
use App\Models\Director;
use App\Http\Resources\DirectorResource;

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
}
