<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TA Applications') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 ">
<nav class="bg-white  border-b border-gray-100 ">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-xl font-semibold text-gray-800 ">
                        TA Applications
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-4">
                {{-- If user is authenticated, shows names, role --}}
                @auth
                    <span class="text-sm text-gray-700 ">
                            {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                            <span class="text-gray-500">({{ Auth::user()->role }})</span>
                        </span>
                    <a href="{{ route('user.profile') }}"
                       class="text-sm text-gray-700 hover:text-gray-900">
                        Profile
                    </a>
                    <a href="{{ route('tasks.index') }}"
                       class="text-sm text-gray-700 hover:text-gray-900">
                        Tasks
                    </a>
                    {{-- If user is a teacher, lets them create a task --}}
                    @if(Auth::user()->isTeacher())
                        <a href="{{ route('tasks.create') }}"
                           class="text-sm text-gray-700 hover:text-gray-900">
                            Create Task
                        </a>
                    @endif

                    {{-- Form handles logout, if user is logged in --}}
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        {{-- Protects the form from Cross site request forgeries --}}
                        @csrf
                        <button type="submit"
                                class="text-sm text-gray-700 hover:text-gray-900 hover:cursor-pointer">
                            Logout
                        </button>
                    </form>
                    {{-- If user is not logged in, shows login link --}}
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm text-gray-700 hover:text-gray-900">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<main class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @yield('content')
    </div>
</main>
<footer class="bottom-0 w-full fixed text-center bg-gray-200">PHP IS-115 2025</footer>

@yield('scripts')
</body>
</html>
