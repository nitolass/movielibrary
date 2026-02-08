<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Movie;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory,  Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'role_id',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role(){
        return $this->belongsTo(Role::class);    }

    public function isAdmin(){
        return $this->role && $this->role->name === 'admin';
    }


    public function favorites()
    {
        return $this->belongsToMany(Movie::class, 'movie_user')
            ->wherePivot('type', 'favorite')
            ->withPivot('type') // Importante para poder acceder al tipo
            ->withTimestamps();
    }

    public function watchLater()
    {
        return $this->belongsToMany(Movie::class, 'movie_user')
            ->wherePivot('type', 'watch_later')
            ->withPivot('type')
            ->withTimestamps();
    }

    public function watched()
    {
        return $this->belongsToMany(Movie::class, 'movie_user')
            ->wherePivot('type', 'watched')
            ->withPivot('type')
            ->withTimestamps();
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}

