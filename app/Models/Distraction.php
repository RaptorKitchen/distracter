<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distraction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content', 'media_path', 'media_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    // Exclude the logged-in user
    public function scopeExcludeUser($query, ?int $userId)
    {
        if ($userId) {
            $query->where('user_id', '!=', $userId);
        }
        return $query;
    }

    // followed list
    public function scopeFromUsers($query, $ids)
    {
        if ($ids && $ids->isNotEmpty()) {
            $query->whereIn('user_id', $ids);
        }
        return $query;
    }

    // unfollowed list computation
    public function scopeNotFromUsers($query, $ids)
    {
        if ($ids && $ids->isNotEmpty()) {
            $query->whereNotIn('user_id', $ids);
        }
        return $query;
    }

    // Eager-load + ordering + limit
    public function scopeRecentWithRelations($query, int $limit = 25)
    {
        return $query->with(['user', 'reactions.user'])
                     ->latest()
                     ->take($limit);
    }
}
