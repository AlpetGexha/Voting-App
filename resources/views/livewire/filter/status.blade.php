<nav class="hidden md:flex items-center justify-between text-gray-400 text-xs">
    <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
        <li>
            <a wire:click.prevent="setStatus('All')" href="#"
                class="border-b-4 pb-3 hover:border-blue  {{ $status === 'All' ? 'border-blue text-gray-900' : '' }}">
                {{ __('All Ideas') }} {{ getAmount($countStatus['all_statuses']) }}
            </a>
        </li>
        <li>
            <a wire:click.prevent="setStatus('Considering')" href="#"
                class=" transition duration-150 ease-in border-b-4 pb-3 hover:border-blue  {{ $status === 'Considering' ? 'border-blue text-gray-900' : '' }}">
               {{ __('Considering') }} {{ getAmount($countStatus['considering']) }}
            </a>
        </li>
        <li>
            <a wire:click.prevent="setStatus('In Progress')" href="#"
                class=" transition duration-150 ease-in border-b-4 pb-3 hover:border-blue  {{ $status === 'In Progress' ? 'border-blue text-gray-900' : '' }}">
                {{ __('In Progress') }} {{ getAmount($countStatus['in_progress']) }}
            </a>
        </li>
    </ul>

    <ul class="flex uppercase font-semibold border-b-4 pb-3 space-x-10">
        <li>
            <a wire:click.prevent="setStatus('Implemented')" href="#"
                class=" transition duration-150 ease-in border-b-4 pb-3 hover:border-blue  {{ $status === 'Implemented' ? 'border-blue text-gray-900' : '' }}">
                {{ __('Implemented') }} {{ getAmount($countStatus['implemented']) }}
            </a>
        </li>
        <li>
            <a wire:click.prevent="setStatus('Close')" href="#"
                class=" transition duration-150 ease-in border-b-4 pb-3 hover:border-blue  {{ $status === 'Close' ? 'border-blue text-gray-900' : '' }}">
               {{ __('Close') }} {{ getAmount($countStatus['closed']) }}
            </a>
        </li>
    </ul>
</nav>
