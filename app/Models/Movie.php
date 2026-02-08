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

    /* -------------------------------------------------------------------------- */
    /* RELACIONES                                                                 */
    /* -------------------------------------------------------------------------- */

    public function director() { return $this->belongsTo(Director::class); }
    public function genres() { return $this->belongsToMany(Genre::class); }
    public function actors() {
        return $this->belongsToMany(Actor::class, 'actor_movie')
            ->withPivot('character_name')
            ->withTimestamps();
    }
    public function reviews(){ return $this->hasMany(Review::class); }

    /* -------------------------------------------------------------------------- */
    /* SCOPES (8 TOTAL: 5 COMPLEJOS, 3 SIMPLES)                                   */
    /* -------------------------------------------------------------------------- */

    // Complejo

    public function scopeSearch(Builder $query, $term)
    {
        if(!$term) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('year', 'like', "%{$term}%")
                // Relación 1
                ->orWhereHas('director', function ($dirQ) use ($term) {
                    $dirQ->where('name', 'like', "%{$term}%");
                })
                // Relación 2
                ->orWhereHas('genres', function ($genQ) use ($term) {
                    $genQ->where('name', 'like', "%{$term}%");
                })
                // Relación 3
                ->orWhereHas('actors', function ($actQ) use ($term) {
                    $actQ->where('name', 'like', "%{$term}%");
                });
        });
    }

    //complejo
    public function scopeByGenres(Builder $query, $genres)
    {
        if (empty($genres)) return $query;

        return $query->whereHas('genres', function ($q) use ($genres) {
            $q->whereIn('genres.id', $genres);
        });
    }

    //complejo
    public function scopeAcclaimed(Builder $query)
    {
        return $query->where(function($q) {
            $q->where('score', '>=', 9.0)
                ->orWhere(function($subQ) {
                    $subQ->where('score', '>=', 7.5)
                        ->has('reviews', '>=', 3);
                });
        });
    }

    // complejo
    public function scopeMostReviewed(Builder $query)
    {
        return $query->withCount('reviews')
            ->orderBy('reviews_count', 'desc');
    }

    // complejo
    public function scopeByDirectorCountry(Builder $query, $countryCode)
    {
        return $query->whereHas('director', function($q) use ($countryCode) {
            $q->where('nationality', 'like', "%$countryCode%");
        });
    }

    public function scopeRecent(Builder $query)
    {
        return $query->orderBy('year', 'desc');
    }

    public function scopeClassics(Builder $query)
    {
        return $query->where('year', '<', 2000);
    }

    public function scopeDurationBetween(Builder $query, $min, $max)
    {
        return $query->whereBetween('duration', [$min, $max]);
    }
}
