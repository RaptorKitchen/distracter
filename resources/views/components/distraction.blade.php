<div class="my-4 py-4 flex flex-col items-start">
{{-- max-w-xl is a good "standard" width for posts, but it should be added back once we have other things to put in the sidebar that doesn't exist yet --}}
    <div class="{{--max-w-xl--}}p-4 bg-white rounded-2xl shadow-md border border-gray-200">
        @if (isset($show_authors) && $show_authors)
            <div class="flex items-start space-x-4 mb-2">
                <a href="{{ '@' . $distraction->user->username }} ">
                    <img src="{{ $distraction->user->profile_image_filename ?? 'images/distracter-logo-only.png' }}" alt="{{ $distraction->user->name }} Profile Image" class="w-16 h-16 rounded-full">
                </a>
                <div>
                    <h1 class="text-2xl font-bold">{{ $distraction->user->name }}</h1>
                    <p class="text-sm text-gray-500"><a href="{{ '@' . $distraction->user->username }} ">{{ '@' . $distraction->user->username }}</a></p>
                </div>
                <div class="text-right align-middle grow">
                    @include('components.follow-unfollow-button')
                </div>
            </div>
        @endif

        <p class="text-gray-800 text-base">{{ $distraction->content }}</p>

        @if ($distraction->media_path)
            <div class="mt-2">
                @if ($distraction->media_type === 'image')
                    <img src="{{ asset($distraction->media_path) }}" alt="Distraction Media" class="max-w-full rounded-lg shadow-md">
                @elseif ($distraction->media_type === 'video')
                    <video controls class="max-w-full rounded-lg shadow-md">
                        <source src="{{ asset($distraction->media_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>
        @endif
        <span class="mt-1 text-sm text-gray-500">
            Posted {{ $distraction->created_at->diffForHumans() }}
        </span>
    </div>
    @include('components.reactions', ['distraction' => $distraction])
</div>