<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DirectorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'birth_year' => 'nullable|digits:4|integer',
            'nationality' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ];
    }
}
