<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'birth_year',
        'nationality',
        'photo',
    ];

    // Relación N:M con películas
    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }
}
