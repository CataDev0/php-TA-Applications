@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-semibold mb-6">TA Dashboard</h1>

                <p class="text-gray-600 mb-8">
                    Welcome, {{ Auth::user()->firstname }}! What would you like to do today?
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- View Tasks Card -->
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                        <div class="mb-4">
                            <svg class="w-12 h-12 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold mb-2">View Tasks</h2>
                        <p class="text-gray-600 mb-4">
                            See available tasks and manage your accepted assignments
                        </p>
                        @php
                            $userEmner = Auth::user()->taEmner;
                        @endphp
                        @if($userEmner->isEmpty())
                            <p class="text-sm text-yellow-600 mb-3 italic">
                                ⓘ You need to be accepted for a position to see tasks
                            </p>
                        @endif
                        <a href="{{ route('tasks.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            View Tasks
                        </a>
                    </div>

                    <!-- TA Positions Card -->
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                        <div class="mb-4">
                            <svg class="w-12 h-12 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold mb-2">TA Positions</h2>
                        <p class="text-gray-600 mb-4">
                            Browse and apply for open TA positions in different subjects
                        </p>
                        <a href="{{ route('ta-positions.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            View Positions
                        </a>
                    </div>
                </div>

                <!-- Info Section -->
                @php
                    $userEmner = Auth::user()->taEmner;
                @endphp
                @if($userEmner->isEmpty())
                    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Getting Started as a TA</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p class="mb-2">You're not assigned to any subjects yet. Here's how to get started:</p>
                                    <ol class="list-decimal pl-5 space-y-1">
                                        <li>Browse <strong>TA Positions</strong> to see all available openings</li>
                                        <li>Apply for positions in subjects you're interested in</li>
                                        <li>Wait for a teacher to accept your application</li>
                                        <li>Once accepted, you'll see tasks for that subject</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h2 class="text-xl font-semibold mb-4">Your Assigned Subjects</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            @foreach($userEmner as $emne)
                                <div class="border border-gray-200 rounded-lg p-4 bg-green-50 border-green-200">
                                    <div class="font-semibold text-green-900">{{ $emne->emne }}</div>
                                    <div class="text-xs text-green-600 mt-1">Assigned</div>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-4 text-sm text-gray-600">
                            You can see tasks for these subjects. Apply for more positions to get assigned to additional Subjects.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

