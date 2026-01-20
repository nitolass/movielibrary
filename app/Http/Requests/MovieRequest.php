<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'year' => 'required|string|max:4',
            'description' => 'required|string',
            'duration' => 'required|integer|min:1',
            'age_rating' => 'required|integer|min:0',
            'country' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // Un id de director
            'director_id' => 'required|exists:directors,id',

            // relaciones n:m
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',

            'actors' => 'nullable|array',
            'actors.*' => 'exists:actors,id',
        ];
    }
}
