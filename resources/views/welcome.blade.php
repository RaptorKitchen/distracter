@include('layouts.header')
<main class="mt-6">
    <div class="grid gap-6 lg:grid-cols-1 lg:gap-8">
        @php $user = Auth::user(); @endphp
        @if ($user && $user->following->isEmpty())
            <h2 class="text-xl font-semibold mb-4">You are not following anyone yet. Honestly, good for you.</h2>
            <p class="mb-4">If you're trying to get more distracted, start following other distracters to see their distractions here.</p>
            <h2 class="text-xl font-semibold mb-4">In the meantime, here are some recent distractions.</h2>
        @elseif ($user)
            <h2 class="text-xl font-semibold mb-4">Distractions by followed Distractors</h2>
        @else
            <h2 class="text-xl font-semibold mb-4">Recent distractions</h2>
        @endif
        
        @foreach ($distractions as $distraction)
            @include('components.distraction', ['distraction' => $distraction, 'show_authors' => true])
        @endforeach

        <h2 class="text-xl font-semibold mb-4">More distractions</h2>
        @foreach ($recentDistractionsMinusFollowed as $recentDistraction)
            @include('components.distraction', ['distraction' => $recentDistraction, 'show_authors' => true])
        @endforeach
    </div>
</main>
@include('layouts.footer')