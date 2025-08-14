<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        $follower = auth()->user();

        if ($follower->id === $user->id) {
            return back()->withErrors('Sorry, you cannot follow yourself. Unfortunately.');
        }

        // Avoid duplicate follows
        $follower->following()->syncWithoutDetaching([$user->id]);

        return back();
    }

    public function unfollow(User $user)
    {
        $follower = auth()->user();
        $follower->following()->detach($user->id);

        return back();
    }
}
