
@php
    $groupedReactions = $distraction->reactions->groupBy('emoji');
@endphp

{{--<span class="block pt-2 text-black/50">{{$groupedReactions->count() > 0 ? $groupedReactions->count() . ' Reaction(s)' : 'No reactions yet'}}</span>--}}
<div class="flex items-center flex-wrap gap-2 my-2">
    <!-- Show existing reactions -->
    @foreach ($groupedReactions as $emoji => $reactions)
        {{-- TODO: Add a modal to show reactions with users who reacted, grouped --}}
        @php
            // Join all the usernames who reacted with this emoji
            $reactionUsers = '@' . $reactions->pluck('user.username')->join(', @');
        @endphp
        <form method="POST" action="{{ route('reactions.toggle', $distraction->id) }}" class="inline">
            @csrf
            <input type="hidden" name="emoji" value="{{ $emoji }}">
            <button 
                type="submit" 
                class="max-w-xl p-2 bg-white rounded-2xl shadow-md"
                title="Reacted by: {{ $reactionUsers }}"
            >
                {{ $emoji }} <span class="text-black/50">{{ $reactions->count() }}</span>
            </button>
        </form>
    @endforeach

    <!-- Add a new reaction -->
    <div x-data="emojiReactionForm('{{ $distraction->id }}')" class="relative inline-block">
        <button 
            type="button" 
            @click="togglePicker" 
            class="px-2 py-1 bg-white rounded"
        >
            ✚ React
        </button>

        <form 
            x-ref="form" 
            method="POST" 
            action="{{ route('reactions.toggle', $distraction->id) }}" 
            class="hidden"
        >
            @csrf
            <input type="hidden" name="emoji" x-ref="input">
        </form>

        <div 
            x-show="pickerVisible" 
            @click.outside="pickerVisible = false" 
            class="absolute z-50 mt-2"
        >
            <emoji-picker @emoji-click="submitEmoji"></emoji-picker>
        </div>
    </div>
</div>

