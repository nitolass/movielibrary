<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $fillable = [
        'name',
        'biography',
        'birth_year',
        'nationality',
        'photo',
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }
}
