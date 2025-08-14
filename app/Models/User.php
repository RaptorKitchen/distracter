<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'profile_image_filename',
        'password',
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

    public function followers() {
        return $this->belongsToMany(User::class, 'follows', 'followee_id', 'follower_id');
    }

    public function following() {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followee_id');
    }

    public function followedIds()
    {
        return $this->following()->pluck('users.id');
    }

    public function distractions()
    {
        return $this->hasMany(Distraction::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

}
