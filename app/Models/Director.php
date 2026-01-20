<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'biography',
        'birth_year',
        'nationality',
        'photo',
    ];

    // Relación 1:N
    public function movies()
    {
        return $this->hasMany(Movie::class);
    }
}
