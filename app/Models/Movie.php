<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Director;
use App\Models\Genre;
use App\Models\Actor;
use App\Models\Review;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'year',
        'description',
        'duration',
        'poster',
        'director_id',
        'genre_id',
        'score'
    ];


    public function director() { return $this->belongsTo(Director::class); }
    public function genres() { return $this->belongsToMany(Genre::class); }
    public function actors() {
        return $this->belongsToMany(Actor::class, 'actor_movie')
            ->withPivot('character_name')
            ->withTimestamps();
    }
    public function reviews(){ return $this->hasMany(Review::class); }


    public function scopeSearch(Builder $query, $term)
    {
        if(!$term){
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('year', 'like', "%{$term}%")
                ->orWhereHas('director', function ($dirQuery) use ($term) {
                    $dirQuery->where('name', 'like', "%{$term}%");
                });
        });
    }

    public function scopeByGenres(Builder $query, $genres)
    {
        if (empty($genres)) {
            return $query;
        }

        return $query->whereHas('genres', function ($q) use ($genres) {
            $q->whereIn('genres.id', $genres);
        });
    }

    public function scopeRecent(Builder $query)
    {
        return $query->orderBy('year', 'desc');
    }
}
