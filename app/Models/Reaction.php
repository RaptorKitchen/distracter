<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    protected $fillable = ['user_id', 'distraction_id', 'emoji'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function distraction()
    {
        return $this->belongsTo(Distraction::class);
    }
}
