<div x-data="{
    likeCount: $wire.count,
    isLiked: $wire.isLike,
    toogleLike: function() {
        if (this.isLiked) {
            this.likeCount--;
            this.isLiked = false;
        } else {
            this.likeCount++;
            this.isLiked = true;
        }
    }
}">
    <button
        type="button"
        wire:click.prevent='like()'
        wire:loading.attr="disabled"
        wire:loading.class="!cursor-wait"
        @if(auth()->check()) x-on:click="toogleLike" @endif
        x-bind:class="isLiked ? 'text-red' : 'text-blue'"
        class="outline-none inline-flex justify-center items-center group transition-all ease-in duration-150 focus:ring-2 focus:ring-offset-2 hover:shadow-sm disabled:opacity-80 disabled:cursor-not-allowed gap-x-2 text-sm leading-4 px-3 py-2  rounded-full      ring-blue-500 text-blue-500 border border-blue-500 hover:bg-blue-50 dark:ring-offset-slate-800 dark:hover:bg-slate-700">


        <template x-if='!isLiked'>
            <svg class="w-3.5 h-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                </path>
            </svg>
        </template>

        <template x-if='isLiked'>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="w-3.5 h-3.5 shrink-0">
                <path
                    d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
            </svg>
        </template>

        <span x-text="likeCount"></span>
    </button>

</div>
