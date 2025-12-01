@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto mt-4">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 ">
                <h1 class="text-2xl font-semibold mb-4">Welcome to TApp</h1>

                <p class="text-gray-600  mb-6">
                    A management system for teaching assistant applications.
                </p>

                <div class="space-y-4">
                    {{-- Shows different button based on authentication status (Is user logged in) --}}
                    @auth
                        <div><a href="{{ route('dashboard') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-800  border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700  focus:bg-gray-700 active:bg-gray-900  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Go to Dashboard
                            </a>
                        </div>
                    @else
                        <div class="flex gap-4">
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700  focus:bg-gray-700  active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Log in
                            </a>

                            {{-- Only show register button if user is not logged in --}}
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center px-4 py-2 bg-white border-gray-300  rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                    Register
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
