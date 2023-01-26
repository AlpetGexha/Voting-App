<div>
    <div class="filters flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-6">
        <div class="w-full md:w-1/3">
            <select wire:model='category' class="w-full rounded-xl border-none px-4 py-2">
                <option value=''>All</option>
                @foreach ($categorys as $category)
                    {{-- set all option  with category on null --}}
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full md:w-1/3">
            <select wire:model='filter' name="other_filters" id="other_filters"
                class="w-full rounded-xl border-none px-4 py-2">
                <option value="">No Filter</option>
                <option value="trending">Trending</option>
                <option value="mostVotedOnWeek">Most Voed (Week)</option>
                <option value="mostVotedOnMounth">Most Voted (Mounth)</option>
                <option value="most_comments">Most Comments</option>
                @auth
                    <option value="myIdeas">My Ideas</option>
                @endauth
                @admin
                    <option value="spamIdeas">Most Spam Ideas</option>
                    <option value="reportedIdeas">Most Reported Ideas </option>
                @endadmin
            </select>
        </div>
        <div class="w-full md:w-2/3 relative">
            <input wire:model='search' type="search" placeholder="Find an idea"
                class="w-full rounded-xl bg-white border-none placeholder-gray-900 px-4 py-2 pl-8">
            <div class="absolute top-0 flex itmes-center h-full ml-2">
                <svg class="w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div> <!-- end filters -->

    <div class="ideas-container space-y-6 my-8" wire:init='loadData'>
        @if ($isReatyToLoad)

            @forelse ($ideas as $idea)
                <livewire:idea.index :key='$idea->id' :idea='$idea' :voteCount="$idea->votes_count" />
            @empty
                <div class="idea-container bg-white rounded-xl flex">
                    <div class="border-r border-gray-100 px-5 py-8">
                        <div class="text-center border-2 border-gray-200 w-14 h-14 mx-auto rounded-xl">
                            <svg class="w-6 h-6 text-gray-200 mx-auto" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col justify-between px-4 py-6">
                        <h4 class="text-xl font-semibold mt-2">
                            {{ __('No ideas found!') }}
                        </h4>
                        <div class="text-gray-600 mt-3">
                            <p>
                                {{ __('If you dont find an idea in the list, you can post one yourself.') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
            <div class="my-6">
                {{ $ideas->links() }}
                {{-- {{ $ideas->appends(quest()->query())->links() }} --}}
            </div>
        @else
            {{-- Skeleton Load --}}
            @foreach (range(1, 3) as $index)
                <x-skeleton-load />
            @endforeach
        @endif
    </div> <!-- end ideas-container -->
</div>
