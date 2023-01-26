<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Alpet Gexha">

    {!! SEO::generate() !!}

    <link rel="icon" href="{{ asset('img/logo.svg') }}" type="image/x-icon" />
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    {{-- <link rel="stylesheet" href="{{ asset('vendor/megaphone/css/megaphone.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <wireui:scripts />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans bg-gray-background text-gray-900 text-sm">
    {{-- {!! auth()->user()->assignRole('super_admin') !!} --}}
    <x-notifications />

    <header class="flex flex-col md:flex-row items-center justify-between px-8 py-4">
        <a href="{{ route('ideas.ideas') }}">
            <img src="{{ asset('img/logo.svg') }}" alt="logo" class="w-12">
        </a>
        <div class="flex items-center mt-2 md:mt-0">
            @if (Route::has('login'))
                <div class="px-6 py-4">
                    @auth
                        {{-- <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log out') }}
                            </a>
                        </form> --}}
                        {{-- <livewire:megaphone></livewire:megaphone> --}}
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">
                            {{ __('Log in') }}
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">
                                {{ __('Register') }}
                            </a>
                        @endif
                    @endauth

                </div>
            @endif

            @auth
                {{-- <a href="#">
                    <img src="{{ auth()->user()->getAvatar() }}" alt="{{ auth()->user()->name }}" loading="lazy"
                        class="w-10 h-10 rounded-full">
                </a> --}}

                <livewire:action.comment-notification />
                {{-- @livewire('notifications') --}}
                {{--  --}}

                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">

                            {{-- <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ auth()->user()->getAvatar() }}" alt="{{ auth()->user()->name }}" />
                                </button> --}}

                            <span class="inline-flex rounded-md">
                                <button type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                    {{ auth()->user()->name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </span>

                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-800">
                                {{ __('Manage Account') }}
                            </div>

                            @admin
                                <x-jet-dropdown-link href="{{ route('filament.pages.dashboard') }}">
                                    {{ __('Dashboard') }}
                                </x-jet-dropdown-link>
                            @endadmin

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-jet-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>

            @endauth
        </div>
    </header>

    <main class="container mx-auto max-w-custom flex flex-col md:flex-row">
        <div class="w-70 mx-auto md:mx-0 md:mr-5">
            <div class="bg-white md:sticky md:top-8 border-2 border-blue rounded-xl mt-16"
                style="
                      border-image-source: linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
                        border-image-slice: 1;
                        background-image: linear-gradient(to bottom, #ffffff, #ffffff), linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
                        background-origin: border-box;
                        background-clip: content-box, border-box;
                ">
                <div class="text-center px-6 py-2 pt-6">
                    <h3 class="font-semibold text-base">{{ __('Add an idea') }}</h3>
                    <p class="text-xs mt-4">
                        @auth
                            {{ __('Let us know what you would like and we will take a look over!') }}
                        @else
                            {{ __('Please login to create an idea.') }}
                        @endauth
                    </p>
                </div>

                @auth
                    <livewire:idea.create />
                @else
                    <div class="my-6 text-center">
                        <a href="{{ route('login') }}"
                            class="inline-block justify-center w-1/2 h-11 text-xs bg-blue text-white font-semibold rounded-xl border border-blue hover:bg-blue-hover transition duration-150 ease-in px-6 py-3">
                            <span class="ml-1">{{ __('Login') }}</span>
                        </a>
                        <a href="{{ route('register') }}"
                            class="inline-block justify-center w-1/2 h-11 text-xs bg-gray-200 font-semibold rounded-xl border border-gray-200 hover:border-gray-400 transition duration-150 ease-in px-6 py-3 mt-4">
                            {{ __('Sign Up') }}
                        </a>
                    </div>
                @endauth

            </div>
        </div>
        <div class="w-full px-2 md:px-0 md:w-175">
            <livewire:filter.status />

            <div class="mt-8">
                {{ $slot }}
            </div>
        </div>
    </main>

    @livewireScripts
</body>

</html>
