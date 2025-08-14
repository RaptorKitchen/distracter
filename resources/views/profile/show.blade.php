<x-app-layout>
    <div class="max-w-2xl mx-auto py-10">
        <div class="flex items-center space-x-4 mb-6">
            <img src="{{ $user->profile_image_filename ?? 'images/distracter-logo-only.png' }}" alt="{{ $user->name }} Profile Image" class="w-16 h-16 rounded-full">

            <div>
                <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                <p class="text-sm text-gray-500">{{ '@' . $user->username }}</p>
            </div>
            <div class="text-right grow">
                <p class="text-sm text-gray-500">Followers: {{ count($user->followers) }}</p>
                <p class="text-sm text-gray-500">Following: {{ count($user->following) }}</p>
                <p class="text-sm text-gray-500 mt-1">Member since {{ $user->created_at->format('M Y') }}</p>
                @include('components.follow-unfollow-button')
            </div>
        </div>

        @if (auth()->id() === $user->id)
            <div x-data="{ text: '' }">
                <form action="{{ route('distractions.store') }}" method="POST" class="mb-4" enctype="multipart/form-data">
                    @csrf
                    <textarea x-model="text" name="content" class="w-full border rounded p-2" maxlength="560" required placeholder="What's would you like to distract with today?"></textarea>
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-sm text-gray-500" x-text="`${text.length} / 560 characters`"></p>
                        <div>
                            <p class="text-sm text-gray-800">Add media (optional)</p>
                            <input type="file" name="media" accept="image/*,video/*">
                        </div>
                        <x-primary-button class="mt-2">Post Distraction</x-primary-button>
                    </div>
                </form>

            </div>

        @endif

        <h2 class="text-xl font-semibold mb-4">{{ auth()->id() === $user->id ? 'Your ' : '' }}Recent Distractions</h2>

        @foreach ($distractions as $distraction)
            @include('components.distraction', ['distraction' => $distraction])
        @endforeach
    </div>
</x-app-layout>
