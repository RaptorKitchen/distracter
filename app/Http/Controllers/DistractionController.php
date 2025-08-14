<?php

namespace App\Http\Controllers;

use App\Models\Distraction;
use Illuminate\Http\Request;

class DistractionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:560',
            'media' => 'nullable|file|max:51200', // 50MB limit for now
        ]);

        $path = null;
        $type = null;

        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $mime = $file->getMimeType();

            if (str_starts_with($mime, 'image/')) {
                $type = 'image';
            } elseif (str_starts_with($mime, 'video/')) {
                $type = 'video';
            } else {
                return back()->withErrors(['media' => 'Only images or videos files are allowed.']);
            }

            $path = $file->store('distraction-media', 'public');
        }

        auth()->user()->distractions()->create([
            'content' => $request->content,
            'media_path' => $path,
            'media_type' => $type,
        ]);

        return back();
    }

    public function following(Request $request)
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

        return view('following-feed', [
            'distractions' => $distractions,
            'recentDistractionsMinusFollowed' => $recentDistractionsMinusFollowed,
        ]);
    }
}
