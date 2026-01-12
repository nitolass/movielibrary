<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cambiar según middleware si quieres
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'year' => 'required|string|max:4',
            'description' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'age_rating' => 'required|integer|min:0',
            'country' => 'required|string|max:255',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // Relaciones N:M
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',

            'directors' => 'nullable|array',
            'directors.*' => 'exists:directors,id',

            'actors' => 'nullable|array',
            'actors.*' => 'exists:actors,id',
        ];
    }
}
