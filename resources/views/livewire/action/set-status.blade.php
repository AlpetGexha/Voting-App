<div
    x-data="{ isOpen: false }"
    x-init="
        window.livewire.on('statusUpdated', () => {
            isOpen = false
        })"
    class="relative"
>
    <button
        @click="isOpen = !isOpen"
        class="flex items-center justify-center w-36 h-11 text-sm bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3 mt-2 md:mt-0"
        type="button">
        <span> {{ __('Set Status') }} </span>
        <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div
        x-show.transition.origin.top.left="isOpen"
        @click.away="isOpen = false"
        @keydown.escape.window="isOpen = false"
        class="absolute z-20 w-64 md:w-76 text-left font-semibold text-sm bg-white shadow-dialog rounded-xl mt-2"
        x-cloak>

        <form wire:submit.prevent="setStatus" action="#" class="space-y-4 px-4 py-6">
            <div class="space-y-2">
                @foreach ($statuss as $s)
                    <div>
                        <label class="inline-flex items-center">
                            <input
                                wire:model="status" type="radio"
                                class="bg-gray-200 text-gray-600 border-none"
                                name="status"
                                value="{{ $s->id }}" {{ $status === $s->id ? 'checked' : '' }}>
                            <span class="ml-2">{{ $s->name }}</span>
                        </label>
                    </div>
                @endforeach
            </div>

            <div>
                <textarea name="update_comment" id="update_comments" cols="30" rows="3"
                    class="w-full text-sm bg-gray-100 rounded-xl placeholder-gray-900 border-none px-4 py-2"
                    placeholder="Add an update comment (optional)"></textarea>
            </div>

            <div class="flex items-center justify-between space-x-3">
                <button type="button"
                    class="flex items-center justify-center w-1/2 h-11 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3">
                    <svg class="text-gray-600 w-4 transform -rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                    </svg>
                    <span class="ml-1">{{ __('Attach') }}</span>
                </button>
                <button type="submit" wire:loading.attr='disabled'
                    class="flex items-center justify-center w-1/2 h-11 text-xs bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3 disabled:opacity-50">
                    <span class="ml-1">
                        {{ __('Update') }}
                    </span>
                </button>
            </div>

            <div>
                <label class="font-normal inline-flex items-center">
                    <input wire:model='notifyUsers' type="checkbox" name="notify_voters" class="rounded bg-gray-200" checked="">
                    <span class="ml-2">{{ __('Notify all voters') }}</span>
                </label>
            </div>
        </form>
    </div>
</div>
