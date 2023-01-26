<div id="comment-{{ $comment->id }}"
    class="@if ($comment->is_status_update) is-status-update {{ 'status-' . Str::kebab($comment->status->name) }} @endif comment-container relative bg-white rounded-xl flex transition duration-500 ease-in mt-4">
    <div class="flex flex-col md:flex-row flex-1 px-4 py-6">
        <div class="flex-none">
            <a href="#">
                <span class="inline-block relative">
                    <img src="{{ $comment->user->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-xl">

                    @if($comment->user->isVerified())
                        {{-- <span title="Verified" class="absolute top-0 left-0 block h-1.5 w-1.5 transform -translate-y-1/2 translate-x-1/2 rounded-full ring-2 ring-white bg-gray-300"> --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="w-5 h-5 absolute top-0 left-[-1.0rem] block transform -translate-y-1/2 translate-x-1/2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                        {{-- </span> --}}
                    @endif
                </span>
            </a>

            @if ($comment->user->isAdmin())
                <div class="md:text-center uppercase text-blue text-xxs font-bold mt-1">Admin</div>
            @endif

        </div>
        <div class="w-full md:mx-4">
            <div class="text-gray-600">

                @admin
                    @if ($comment->spams_count > 0)
                        <div class="text-red mb-2">Spam Reports: {{ $comment->spams_count }}</div>
                    @endif
                @endadmin

                @if ($comment->is_status_update)
                    <h4 class="text-xl font-semibold mb-3">
                        {{ __('Status Changed to') }} "{{ $comment->status->name }}"
                    </h4>
                @endif

                <div class="mt-4 md:mt-0">
                    {!! nl2br(e($comment->body)) !!}
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center text-xs text-gray-400 font-semibold space-x-2">
                    <div class="@if ($comment->is_status_update) text-blue @endif font-bold text-gray-900">
                        {{ $comment->user->name }}
                    </div>
                    <div>&bull;</div>
                    {{-- @if ($comment->user->id === $comment->idea->user->id) --}}
                    @if($comment->user->isVerified())
                        <div class="rounded-full border bg-gray-100 px-3 py-1">Verified</div>
                        <div>&bull;</div>
                    @endif

                    @if ($comment->user->id === $ideaUserId)
                        <div class="rounded-full border bg-gray-100 px-3 py-1">Author</div>
                        <div>&bull;</div>
                    @endif

                    <div>{{ $comment->created_at->diffForHumans() }}</div>
                </div>
                @auth
                    <div x-data="{ isOpen: false }" class="text-gray-900 flex items-center space-x-2">
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
                                @can('update', $comment)
                                    <li>
                                        <a href="#"
                                            @click.prevent="
                                                isOpen = false
                                                Livewire.emit('setEditComment', {{ $comment->id }})
                                            "
                                            class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">
                                            {{ __('Edit Comment') }}
                                        </a>
                                    </li>
                                @endcan

                                @can('delete', $comment)
                                    <li>
                                        <a href="#"
                                            @click.prevent="
                                                isOpen = false
                                                Livewire.emit('setDeleteComment', {{ $comment->id }})
                                            "
                                            class="hover:bg-gray-100 text-red-500 block transition duration-150 ease-in px-5 py-3">
                                            {{ __('Delete Comment') }}
                                        </a>
                                    </li>
                                @endcan

                                @if (!$comment->is_status_update && !(auth()->id() == $comment->user_id))
                                    <li>
                                        <a href="#"
                                            @click.prevent="
                                                isOpen = false
                                                Livewire.emit('setMarkAsSpamComment', {{ $comment->id }})
                                            "
                                            class="hover:bg-gray-100 block transition duration-150 ease-in px-5 py-3">
                                            {{ $comment->isSpammedFrom() ? 'Remove from Spam' : 'Mark As Spammed' }}
                                        </a>
                                    </li>
                                @endif

                                @admin
                                    @if ($comment->spams_count > 0)
                                        <li>
                                            <a href="#"
                                                @click.prevent="
                                                    isOpen = false
                                                    Livewire.emit('setMarkAsNotSpamComment', {{ $comment->id }})
                                                "
                                                class="hover:bg-gray-100 text-blue block transition duration-150 ease-in px-5 py-3">
                                                {{ __('Not A Spam') }}
                                            </a>
                                        </li>
                                    @endif
                                @endadmin

                            </ul>
                        </div>
                    </div>
                @endauth
            </div>

            <div>
                <livewire:action.like
                    :model='$comment->getMorphClass()'
                    :model_id='$comment->id'
                    :likedBy='$comment->is_liked_by_user'
                    count="{{ Redis::get('ideas.comments.like.' . $comment->id) ?? 0 }}" />
            </div>

        </div>
    </div>
</div> <!-- end comment-container -->
