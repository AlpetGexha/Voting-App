<div
    x-data
    class="idea-container hover:shadow-card transition duration-150 ease-in bg-white rounded-xl flex cursor-pointer"
    x-init="Livewire.hook('message.processed', (message, component) => {
        {{-- console.log(message) --}}

        {{-- Pagination --}}
        if (['gotoPage', 'previousPage', 'nextPage'].includes(message.updateQueue[0].method)) {
            const firstIdeas = document.querySelector('.filters:first-child')
            firstIdeas.scrollIntoView({ behavior: 'smooth' })
        }
    })">

    <div class="hidden md:block border-r border-gray-100 px-5 py-8">
        <div class="text-center">
            <div class="font-semibold text-2xl {{ $hasVoted ? 'text-blue' : '' }}">{{ $voteCount }}</div>
            <div class="text-gray-500">Votes</div>
        </div>

        <div class="mt-8">
            @if ($hasVoted)
                <button wire:click.prevent='vote()'
                    class="w-20 bg-blue text-white border border-blue hover:bg-blue-hover font-bold text-xxs uppercase rounded-xl transition duration-150 ease-in px-4 py-3">
                    {{ $idea->isClosed() ? 'Closed' : 'Voted' }}
                </button>
            @else
                <button wire:click.prevent='vote()'
                    class="w-20 bg-gray-200 border border-gray-200 hover:border-gray-400 font-bold text-xxs uppercase rounded-xl transition duration-150 ease-in px-4 py-3">
                    {{ $idea->isClosed() ? 'Closed' : 'Vote' }}
                </button>
            @endif
        </div>
    </div>
    <div class="flex flex-col md:flex-row flex-1 px-2 py-6">
        <div class="flex-none mx-2 md:mx-0">
            <a href="#">
                <span class="inline-block relative">
                    <img src="{{ $idea->user->getAvatar() }}" alt="avatar" loading="lazy" class="w-14 h-14 rounded-xl">

                    @if($idea->user->isVerified())
                        <svg class="w-5 h-5 absolute top-0 left-[-1.0rem] block transform -translate-y-1/2 translate-x-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                    @endif
                </span>
            </a>
        </div>
        <div class="w-full flex flex-col justify-between mx-2 md:mx-4">
            {{-- @dd($idea) --}}
            @admin
                @if ($idea->spams_count > 0)
                    <div class="text-red mb-2">Spam Reports: {{ $idea->spams_count }}</div>
                @endif

                @if ($idea->hasReport())
                    <div class="text-red mb-2">Reported : {{ $idea->report_count }}</div>
                @endif
            @endadmin
            <h4 class="text-xl font-semibold mt-2 md:mt-0">
                <a href="{{ route('ideas.show', ['slug' => $idea->slug]) }}" class="idea-link hover:underline">
                    {{ $idea->title }}
                </a>
            </h4>
            <div class="text-gray-600 mt-3 line-clamp-3">
                <p class="break-all">
                    {{ $idea->body }}
                </p>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between mt-6">
                <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                    <div class="text-gray-700">
                        {{ $idea->user->name }} {{ $idea->user->id === auth()->id() ? '(me)' : '' }}
                    </div>
                    <div>&bull;</div>
                    <div>{{ $idea->created_at->diffForHumans() }}</div>
                    <div>&bull;</div>
                    <div>{{ $idea->category->name }}</div>
                    <div>&bull;</div>
                    <div wire:ignore class="text-gray-900">{{ $idea->comments_count }} Comments </div>
                </div>
                <div x-data="{ isOpen: false }" class="flex items-center space-x-2 mt-4 md:mt-0">
                    <div
                        class="{{ $idea->getStatusClass() }} text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">
                        {{ $idea->status->name }}
                    </div>
                    {{-- <button @click="isOpen = !isOpen"
                        class="relative bg-gray-100 hover:bg-gray-200 border rounded-full h-7 transition duration-150 ease-in py-2 px-3">
                        <svg fill="currentColor" width="24" height="6">
                            <path
                                d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z"
                                style="color: rgba(163, 163, 163, .5)">
                        </svg>
                        <ul x-cloak x-show.transition.origin.top.left="isOpen" @click.away="isOpen = false"
                            @keydown.escape.window="isOpen = false"
                            class="absolute w-44 text-left font-semibold bg-white shadow-dialog rounded-xl py-3 md:ml-8 top-8 md:top-6 right-0 md:left-0">
                            <li><a href="#"
                                    class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">Mark
                                    as Spam</a></li>
                            <li><a href="#"
                                    class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">Delete
                                    Post</a></li>
                        </ul>
                    </button> --}}
                </div>

                <div class="flex items-center md:hidden mt-4 md:mt-0">
                    <div class="bg-gray-100 text-center rounded-xl h-10 px-4 py-2 pr-8">
                        <div class="text-sm font-bold leading-none">{{ $idea->votes_count }}</div>
                        <div class="text-xxs font-semibold leading-none text-gray-400">Votes</div>
                    </div>
                    <button
                        class="w-20 bg-gray-200 border border-gray-200 font-bold text-xxs uppercase rounded-xl hover:border-gray-400 transition duration-150 ease-in px-4 py-3 -mx-5">
                        {{ $idea->isClosed() ? 'Closed' : 'Voted' }}
                    </button>
                    @if ($hasVoted)
                        <button wire:click.prevent='vote()'
                            class="w-20 bg-blue text-white border border-blue font-bold text-xxs uppercase rounded-xl hover:border-blue-hover transition duration-150 ease-in px-4 py-3 -mx-5">
                            {{ $idea->isClosed() ? 'Closed' : 'Voted' }}
                        </button>
                    @else
                        <button wire:click.prevent='vote()'
                            class="w-20 bg-gray-200 border border-gray-200 font-bold text-xxs uppercase rounded-xl hover:border-gray-400 transition duration-150 ease-in px-4 py-3 -mx-5">
                            {{ $idea->isClosed() ? 'Closed' : 'Vote' }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div> <!-- end idea-container -->
