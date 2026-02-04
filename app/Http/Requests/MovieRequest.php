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
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'year'        => 'required|integer',
            'duration'    => 'required|integer',
            'director_id' => 'required|exists:directors,id',
            'poster'      => 'nullable|image|max:2048',
            'genres'      => 'required|array',
            'actors'      => 'nullable|array',
        ];
    }
}
