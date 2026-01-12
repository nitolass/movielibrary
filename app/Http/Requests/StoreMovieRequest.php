<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // middleware se encarga del permiso
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'year' => 'required|string|max:4',
            'description' => 'required|string',
            'duration' => 'required|integer|min:1',
            'age_rating' => 'required|integer|min:0|max:18',
            'country' => 'required|string|max:255',
            'poster' => 'nullable|image|max:2048',
        ];
    }
}
