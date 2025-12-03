<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CSH SHOP') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="font-sans text-gray-900 antialiased">

        <div
            class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6 flex justify-between items-center bg-green-600 rounded shadow mb-6">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10 w-auto">

                <h2 class="text-2xl font-bold text-white">{{ config('app.name', 'CSH SHOP') }}</h2>
            </div>
            <div class="flex items-center space-x-4 ">
                <a href="{{ route('cart') }}" class="relative hover:text-green-700 inline-block">
                    <!-- Cart Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="white" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.833l.383 1.437M7.5 14.25h11.39
           c.86 0 1.62-.585 1.82-1.42l1.35-5.39a1.125 1.125 0 0 0-1.09-1.39H5.82M7.5 14.25
           L5.106 5.27M7.5 14.25l-2.47 4.94M10.5 21a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm8.25 1.5
           a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" />
                    </svg>

                    @if (session('cart_count') > 0)
                        <span
                            class="absolute -top-2 left-1/2 transform -translate-x-1/2 bg-red-600 text-white text-xs font-bold
             px-2 py-0.5 rounded-full">
                            {{ session('cart_count') }}
                        </span>
                    @endif
                </a>



                @auth
                    <div x-data="{ open: false }" class="relative ml-2 ">
                        <button @click="open = !open" class="flex items-center space-x-2 text-white focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.121 17.804A9 9 0 1119 12c0 2.21-.896 4.21-2.367 5.683M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="font-semibold">{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown -->
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg border z-50">

                            <!-- Logout Form -->
                            <a href="{{ route('orderan.history') }}"
                                class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-gray-100 hover:text-red-700 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-9-9" />
                                </svg>
                                <span>History</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-gray-100 hover:text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                @endauth


                @guest
                    <a href="{{ route('login') }}" class="relative text-green-900 hover:text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 mr-2" viewBox="0 0 24 24"
                            aria-labelledby="user1Title">
                            <title id="user1Title">User</title>
                            <path fill="#FFF"
                                d="M12 12c2.761 0 5-2.239 5-5s-2.239-5-5-5-5 2.239-5 5 2.239 5 5 5zm0 2c-3.866 0-7 3.134-7 7v1h14v-1c0-3.866-3.134-7-7-7z">
                            </path>
                        </svg>
                    </a>
                @endguest


            </div>


        </div>
        {{ $slot }}
    </div>

</body>

</html>
