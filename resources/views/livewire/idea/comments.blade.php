<div wire:init='loadComments'>
    @if($readyToLoad)
        @if ($comments->isNotEmpty())
            <div class="comments-container relative space-y-6 md:ml-22 pt-4 my-8 mt-1">

                @foreach ($comments as $comment)
                    <livewire:idea.comment
                        :comment='$comment'
                        :ideaUserId='$idea->user->id'
                        :key='$comment->id' />
                @endforeach

                <div class="my-8 md:ml-22">
                    {{ $comments->onEachSide(1)->links() }}
                </div>
            </div> <!-- end comments-container -->
        @else
            <div class="text-center font-semibold text-gray-400 mt-10">
                {{ __('No comments yet. be the first one') }}
            </div>
        @endif

    @else
        @foreach (range(1, 3) as $index)
            <x-skeleton-load />
        @endforeach
    @endif
</div>
