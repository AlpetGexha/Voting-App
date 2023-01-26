<div class="idea-and-buttons container">

    <div class="idea-container bg-white rounded-xl flex mt-4">
        <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
            <div class="flex-none mx-2 md:mx-4">
                <a href="#">
                    <span class="inline-block relative">
                        <img src="{{ $idea->user->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-xl">

                        @if ($idea->user->isVerified())
                            <svg class="w-5 h-5 absolute top-0 left-[-1.0rem] block transform -translate-y-1/2 translate-x-1/2"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                        @endif
                    </span>
                </a>
            </div>

            <div class="w-full mx-2 md:mx-4">
                @admin
                    @if ($idea->spams_count > 0)
                        <div class="text-red mb-2">Spam Reports: {{ $idea->spams_count }}</div>
                    @endif

                    @if ($idea->hasReport())
                        <div wire:ignore class="text-red mb-2">Reported : {{ $idea->report_count }}</div>
                    @endif
                @endadmin
                <h4 class="text-xl font-semibold">
                    <a href="#" class="hover:underline">{{ $idea->title }}</a>
                </h4>
                <div class="text-gray-600 mt-3 break-normal">
                    <p class="break-all">
                        {{ $idea->body }}
                    </p>
                </div>

                <div class="flex flex-col md:flex-row md:items-center justify-between mt-6">
                    <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                        <div class="hidden md:block font-bold text-gray-900">
                            {{ $idea->user->name }} {{ $idea->user->id === auth()->id() ? '(me)' : '' }}
                        </div>
                        <div class="hidden md:block">&bull;</div>
                        <div>{{ $idea->created_at->diffForHumans() }}</div>
                        <div>&bull;</div>
                        <div>{{ $idea->category->name }}</div>
                        <div>&bull;</div>

                        <div class="text-gray-900">{{ $idea->comments()->count() }} Comments</div>
                    </div>
                    <div class="flex items-center space-x-2 mt-4 md:mt-0" x-data="{ isOpen: false }">
                        <div
                            class="{{ $idea->getStatusClass() }}text-xxs font-bold uppercase leading-none rounded-full text-center w-28 h-7 py-2 px-4">
                            {{ $idea->status->name }}</div>
                        <div class="relative">
                            <button
                                class="relative bg-gray-100 hover:bg-gray-200 border rounded-full h-7 transition duration-150 ease-in py-2 px-3"
                                @click="isOpen = !isOpen">
                                <svg fill="currentColor" width="24" height="6">
                                    <path
                                        d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z"
                                        style="color: rgba(163, 163, 163, .5)">
                                </svg>
                            </button>
                            <ul x-show.transition.origin.top.left="isOpen" @click.away="isOpen = false"
                                @keydown.escape.window="isOpen = false"
                                class="absolute w-44 text-left font-semibold bg-white shadow-dialog rounded-xl z-10 py-3 md:ml-8 top-8 md:top-6 right-0 md:left-0"
                                x-cloak>

                                @can('update', $idea)
                                    <li>
                                        <a href="#"
                                            @click.prevent="
                                                isOpen = false
                                                $dispatch('custom-show-edit-modal')
                                            "
                                            class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">
                                            {{ __('Edit Idea') }}
                                        </a>
                                    </li>
                                @endcan

                                @can('delete', $idea)
                                    <li>
                                        <a href="#"
                                            @click.prevent="
                                                isOpen = false
                                                $dispatch('custom-show-delete-modal')
                                            "
                                            class="hover:bg-gray-100 text-red block transition duration-150 ease-in px-5 py-3">
                                            {{ __('Delete Idea') }}
                                        </a>
                                    </li>
                                @endcan

                                <li>
                                    <a href="#"
                                        class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">
                                        Mark as Spam
                                    </a>
                                </li>

                                @can('report')
                                    <li>
                                        <a href="#"
                                            @click.prevent="
                                                isOpen = false
                                                $dispatch('custom-show-report-modal')
                                            "
                                            class="hover:bg-gray-100 text-red block transition duration-150 ease-in px-5 py-3">
                                            {{ __('Report Idea') }}
                                        </a>
                                    </li>
                                @endcan

                                @admin
                                    @if ($idea->spams_count > 0)
                                        <li>
                                            <a href="#"
                                                class="hover:bg-gray-100 text-blue block transition duration-150 ease-in px-5 py-3">
                                                {{ __('Remove from Spam') }}
                                            </a>
                                        </li>
                                    @endif
                                @endadmin
                            </ul>
                        </div>
                    </div>

                    <div class="flex items-center md:hidden mt-4 md:mt-0">
                        <div class="bg-gray-100 text-center rounded-xl h-10 px-4 py-2 pr-8">
                            <div class="text-sm font-bold leading-none {{ $hasVoted ? 'text-blue' : '' }}  ">
                                {{ $voteCount }}
                            </div>

                            <div class="text-xxs font-semibold leading-none text-gray-400">
                                Votes
                            </div>

                        </div>
                        @if ($hasVoted)
                            <button wire:click.prevent='vote()'
                                class="w-20 bg-blue text-white border border-blue font-bold text-xxs uppercase rounded-xl hover:bg-blue-hover transition duration-150 ease-in px-4 py-3 -mx-5">
                                Voted
                            </button>
                        @else
                            <button wire:click.prevent='vote()'
                                class="w-20 bg-gray-200 border border-gray-200 font-bold text-xxs uppercase rounded-xl hover:border-gray-400 transition duration-150 ease-in px-4 py-3 -mx-5">
                                Vote
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end idea-container -->

    <div class="buttons-container flex items-center justify-between mt-6">
        <div class="flex flex-col md:flex-row items-center space-x-4 md:ml-6">
            <livewire:action.add-comment :idea='$idea' />

            <livewire:action.set-status :idea='$idea' />

        </div>

        <div class="hidden md:flex items-center space-x-3">
            <div class="bg-white font-semibold text-center rounded-xl px-3 py-2">
                <div class="text-xl leading-snug @if ($hasVoted) text-blue @endif">
                    {{ $voteCount }}
                </div>
                <div class="text-gray-400 text-xs leading-none">Votes</div>
            </div>

            @if ($hasVoted)
                <button wire:click.prevent='vote()' type="button"
                    class="w-32 h-11 text-xs bg-blue text-white font-semibold uppercase rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                    <span>
                        {{ $idea->isClosed() ? 'Closed' : 'Voted' }}
                    </span>
                </button>
            @else
                <button wire:click.prevent='vote()' type="button"
                    class="w-32 h-11 text-xs bg-gray-200 font-semibold uppercase rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3">
                    <span>
                        {{ $idea->isClosed() ? 'Closed' : 'Vote' }}
                    </span>
                </button>
            @endif

        </div>
    </div> <!-- end buttons-container -->
</div>
