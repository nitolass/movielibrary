<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->user->name, 
            'movie_id' => $this->movie_id,
            'rating' => $this->rating,
            'content' => $this->content,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
