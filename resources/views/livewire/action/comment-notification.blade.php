<div
    x-data="{ isOpen: false }"
    {{-- wire:poll.600ms="getNotificationCount" --}}
    class="relative"
>
    <button @click="isOpen = !isOpen
        if (isOpen) {
            Livewire.emit('getNotifications')
        }
    ">
    @php
        $notificationCount = 5;
    @endphp
        @if ($notificationCount)
            <svg class="h-8 w-8 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
            </svg>
            <div
                class="absolute rounded-full bg-red text-white text-xxs w-6 h-6 flex justify-center items-center border-2 -top-1 -right-1">
                {{ $notificationCount }}
            </div>
        @else
            <svg class="h-8 w-8 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
        @endif
    </button>
    <ul
        class="absolute w-76 md:w-96 text-left text-gray-700 text-sm bg-white shadow-dialog rounded-xl max-h-128 overflow-y-auto z-10 -right-28 md:-right-12"
        x-show.transition.origin.top="isOpen"
        @click.away="isOpen = false"
        @keydown.escape.window="isOpen = false"
        x-cloak
        >
        @if ($notifications->isNotEmpty() && !$isLoading)
            @foreach ($notifications as $notification)
                <li>
                    <a
                        class="flex hover:bg-gray-100 transition duration-150 ease-in px-5 py-3"
                        href="{{ route('ideas.show', ['slug' => $notification->data['idea_slug']]) }}"
                        @click.prevent="isOpen = false"
                        wire:click.prevent="markAsRead('{{ $notification->id }}')"
                        >
                        <img src="{{ $notification->data['user_avatar'] }}" class="rounded-xl w-10 h-10" alt="avatar">
                        <div class="ml-4">
                            <div class="line-clamp-6">
                                <span class="font-semibold">{{ $notification->data['user_name'] }}</span> {{__('commented on')}}
                                <span class="font-semibold">{{ $notification->data['idea_title'] }}</span>:
                                <span>"{{ $notification->data['comment_body'] }}"</span>
                            </div>
                            <div class="text-xs text-gray-500 mt-2">{{ $notification->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
            <li class="border-t border-gray-300 text-center">
                <button
                    @click="isOpen = false"
                    wire:click.prevent='markAllAsRead()'
                    class="w-full block font-semibold hover:bg-gray-100 transition duration-150 ease-in px-5 py-4">
                    {{ __('Mark all as read') }}
                </button>
            </li>
        @elseif ($isLoading)
            @foreach (range(1, 3) as $item)
                <li class="animate-pulse flex items-center transition duration-150 ease-in px-5 py-3">
                    <div class="bg-gray-200 rounded-xl w-10 h-10"></div>
                    <div class="flex-1 ml-4 space-y-2">
                        <div class="bg-gray-200 w-full rounded h-4"></div>
                        <div class="bg-gray-200 w-full rounded h-4"></div>
                        <div class="bg-gray-200 w-1/2 rounded h-4"></div>
                    </div>
                </li>
            @endforeach
        @else
            <li class="mx-auto w-40 py-6">
                <div class="flex justify-center text-center mx-auto">
                    <svg class="w-14 h-14" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.143 17.082a24.248 24.248 0 003.844.148m-3.844-.148a23.856 23.856 0 01-5.455-1.31 8.964 8.964 0 002.3-5.542m3.155 6.852a3 3 0 005.667 1.97m1.965-2.277L21 21m-4.225-4.225a23.81 23.81 0 003.536-1.003A8.967 8.967 0 0118 9.75V9A6 6 0 006.53 6.53m10.245 10.245L6.53 6.53M3 3l3.53 3.53" />
                    </svg>
                </div>
                <div class="text-gray-400 text-center font-bold mt-6">{{ __('No new notifications') }}</div>
            </li>
        @endif
    </ul>
</div>
