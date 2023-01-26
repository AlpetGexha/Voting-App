<div
    x-data="{ isOpen: false }"
    x-show="isOpen"
    @keydown.escape.window="isOpen = false"
    @custom-show-edit-modal.window="
        isOpen = true
        $nextTick(() => $refs.title.focus())
    "
    x-init="
        window.livewire.on('ideaWasUpdated', () => {
            isOpen = false
        })"
    aria-modal="true"
    class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    x-cloak
    >
    <div class="flex items-end justify-center min-h-screen">
        <div
            x-show.transition.opacity="isOpen"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            aria-hidden="true">
        </div>

        <div
            x-show.transition.origin.bottom.duration.300ms="isOpen"
            class="modal bg-white rounded-tl-xl rounded-tr-xl overflow-hidden transform transition-all py-4 sm:max-w-lg sm:w-full">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button
                    @click="isOpen = false"
                    class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-center text-lg font-medium text-gray-900">{{ __('Edit Idea') }}</h3>
                <p class="text-xs text-center leading-5 text-gray-500 px-6 mt-4">
                    {{ __('You have one hour to edit your idea from the time you created it.') }}
                </p>

                <form wire:submit.prevent="updateIdea" action="#" method="POST" class="space-y-4 px-4 py-6">
                    <div>
                        <input wire:model.defer="title" x-ref='title' type="text"
                            class="w-full text-sm bg-gray-100 border-none rounded-xl placeholder-gray-900 px-4 py-2"
                            placeholder="Your Idea" required>
                        @error('title')
                            <p class="text-red text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <select wire:model.defer="category" name="category_add" id="category_add"
                            class="w-full bg-gray-100 text-sm rounded-xl border-none px-4 py-2">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('category')
                        <p class="text-red text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <div>
                        <textarea
                            wire:model.defer="body" name="idea"
                            cols="30" rows="4"
                            class="w-full bg-gray-100 rounded-xl border-none placeholder-gray-900 text-sm px-4 py-2"
                            placeholder="Describe your idea" required></textarea>
                        @error('body')
                            <p class="text-red text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center justify-between space-x-3">
                        <button type="button"
                            class="flex items-center justify-center w-1/2 h-11 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3">
                            <svg class="text-gray-600 w-4 transform -rotate-45" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <span class="ml-1">Attach</span>
                        </button>
                        <button type="submit"
                            class="flex items-center justify-center w-1/2 h-11 text-xs bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                            <span class="ml-1">Update</span>
                        </button>
                    </div>
                </form>
            </div>

        </div> <!-- end modal -->
    </div>
</div>
