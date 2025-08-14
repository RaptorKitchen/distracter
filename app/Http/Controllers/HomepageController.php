<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Distraction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class HomepageController extends Controller
{

    /**
     * Show the homepage's distractions.
     */    
    public function welcome(Request $request): View
    {
        $loggedInUser = auth()->user();
        $loggedInUserId = optional($loggedInUser)->id;
        $followedIds = $loggedInUser ? $loggedInUser->followedIds() : collect();

        $distractions = Distraction::recentWithRelations()
            ->excludeUser($loggedInUserId)
            ->fromUsers($followedIds)
            ->get();

        $recentDistractionsMinusFollowed = Distraction::recentWithRelations()
            ->excludeUser($loggedInUserId)
            ->notFromUsers($followedIds)
            ->get();

        return view('welcome', [
            'distractions' => $distractions,
            'recentDistractionsMinusFollowed' => $recentDistractionsMinusFollowed,
        ]);
    }
}
