<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use App\Models\Distraction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
    public function toggle(Request $request, Distraction $distraction)
    {
        $emoji = $request->emoji;
        $user = auth()->user();

        // Check if this user has already reacted with this emoji
        $existing = Reaction::where('user_id', $user->id)
            ->where('distraction_id', $distraction->id)
            ->where('emoji', $emoji)
            ->first();

        if ($existing) {
            $existing->delete(); // remove reaction if it already exists
        } else {
            Reaction::create([
                'user_id' => $user->id,
                'distraction_id' => $distraction->id,
                'emoji' => $emoji,
            ]);
        }

        return back();
    }
}
