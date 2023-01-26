<x-app-layout>
    <div>
        <a href="{{ $backUrl }}" class="flex items-center font-semibold hover:underline">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="ml-2">{{ __('All Ideas') }}</span>
        </a>
    </div>

    <livewire:idea.show :idea='$idea' :voteCount="$idea->voteCount" />

    @can('update', $idea)
        <livewire:idea.edit :idea='$idea' />
    @endcan

    @can('report')
        <livewire:action.report :model='$idea->getMorphClass()' :model_id='$idea->id' />
    @endcan

    @can('delete', $idea)
        <livewire:idea.delete :idea='$idea' />
    @endcan

    @auth
        <livewire:action.spam-add />
    @endauth

    @admin
        <livewire:action.spam-remove />
    @endadmin

    @auth
        <livewire:action.comment-delete />
    @endauth




    <livewire:idea.comments :idea='$idea' />


</x-app-layout>
