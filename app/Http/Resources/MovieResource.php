<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'year' => $this->year,
            'duration' => $this->duration . ' min',
            'description' => $this->description,
            'poster' => $this->poster ? asset('storage/' . $this->poster) : null,
            'director' => $this->director->name ?? 'Sin director',
            'genres' => $this->genres->pluck('name'),
            'actors' => $this->actors->map(function($actor) {
                return $actor->name;
            }),
        ];
    }
}
