@php
    $targetUserId = isset($distraction)
        ? $distraction->user->id
        : $user->id;
@endphp

@if (auth()->check() && auth()->id() !== $targetUserId)
    @if (auth()->user()->following->contains($targetUserId))
        <form method="POST" action="{{ route('unfollow', ['user' => $targetUserId]) }}">
            @csrf
            @method('DELETE')
            <button class="text-red-500 hover:underline">Unfollow</button>
        </form>
    @else
        <form method="POST" action="{{ route('follow', ['user' => $targetUserId]) }}">
            @csrf
            <button class="text-blue-500 hover:underline">Follow</button>
        </form>
    @endif
@elseif (!auth()->check())
    <p class="text-gray-500">Please log in to follow or unfollow users</p>
@endif
