@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-semibold mb-6">Teacher Dashboard</h1>

                <p class="text-gray-600 mb-8">
                    Welcome, {{ Auth::user()->firstname }}! Manage your courses and TA applications.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- View Tasks Card -->
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                        <div class="mb-4">
                            <svg class="w-12 h-12 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold mb-2">Tasks</h2>
                        <p class="text-gray-600 mb-4">
                            View and manage your application requests
                        </p>
                        <a href="{{ route('tasks.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            View Tasks
                        </a>
                    </div>

                    <!-- Manage Emner Card -->
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                        <div class="mb-4">
                            <svg class="w-12 h-12 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold mb-2">My Subjects</h2>
                        <p class="text-gray-600 mb-4">
                            Manage your subjects and view TA applications
                        </p>
                        <a href="{{ route('emner.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Manage Subjects
                        </a>
                    </div>

                    <!-- Create Task Card -->
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                        <div class="mb-4">
                            <svg class="w-12 h-12 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold mb-2">Create Task</h2>
                        <p class="text-gray-600 mb-4">
                            Create a new application request for TAs
                        </p>
                        <a href="{{ route('tasks.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Create Task
                        </a>
                    </div>
                </div>

                <!-- Quick Stats Section -->
                @php
                    $userEmner = Auth::user()->teacherEmner;
                    $totalApplications = \App\Models\TAApplication::whereHas('position', function($query) use ($userEmner) {
                        $query->whereIn('emne', $userEmner->pluck('emne'));
                    })->where('status', 'pending')->count();
                @endphp

                @if($userEmner->isNotEmpty())
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h2 class="text-xl font-semibold mb-4">Quick Overview</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="text-2xl font-bold text-blue-700">{{ $userEmner->count() }}</div>
                                <div class="text-sm text-blue-600">Assigned Subjects</div>
                            </div>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="text-2xl font-bold text-yellow-700">{{ $totalApplications }}</div>
                                <div class="text-sm text-yellow-600">Pending Applications</div>
                            </div>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="text-2xl font-bold text-green-700">{{ Auth::user()->createdTasks()->count() }}</div>
                                <div class="text-sm text-green-600">Total Tasks Created</div>
                            </div>
                        </div>
                    </div>

                    <!-- My Emner Quick Access -->
                    <div class="mt-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold">My Subjects - Quick Access</h2>
                            <a href="{{ route('emner.index') }}" class="text-sm text-gray-600 hover:text-gray-900">View all →</a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                            @foreach($userEmner->take(4) as $emne)
                                <a href="{{ route('emner.applications', $emne->emne) }}"
                                   class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow hover:border-gray-300">
                                    <div class="font-semibold text-gray-900 mb-1">{{ $emne->emne }}</div>
                                    @php
                                        $pendingCount = \App\Models\TAApplication::whereHas('position', function($query) use ($emne) {
                                            $query->where('emne', $emne->emne);
                                        })->where('status', 'pending')->count();
                                    @endphp
                                    @if($pendingCount > 0)
                                        <div class="text-xs text-yellow-600">{{ $pendingCount }} pending application{{ $pendingCount > 1 ? 's' : '' }}</div>
                                    @else
                                        <div class="text-xs text-gray-500">No pending applications</div>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="mt-8 bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Get Started</h3>
                        <p class="text-gray-600 mb-4">You haven't assigned any emner yet. Start by adding the subjects you teach.</p>
                        <a href="{{ route('emner.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Add Your First Emne
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

