@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-semibold">Applications for {{ $emne }}</h1>
                        <p class="text-sm text-gray-600 mt-1">Review and manage TA applications for this subject</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('emner.positions.create', $emne) }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Create New Position
                        </a>
                        <a href="{{ route('emner.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Back to My Emner
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                @if($positions->isEmpty())
                    <p class="text-gray-600 text-center py-8">No positions created for this emne yet.</p>
                @else
                    @foreach ($positions as $position)
                        <div class="mb-6 border border-gray-200 rounded-lg p-6">
                            <div class="mb-4 pb-4 border-b border-gray-200">
                                <div class="flex justify-between items-start mb-2">
                                    <h2 class="text-xl font-semibold">Position: {{ $position->emne }}</h2>
                                    <form method="POST" action="{{ route('positions.toggle', $position->id) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150
                                                @if($position->status === 'open')
                                                    bg-yellow-100 text-yellow-800 hover:bg-yellow-200 focus:ring-yellow-500
                                                @else
                                                    bg-green-100 text-green-800 hover:bg-green-200 focus:ring-green-500
                                                @endif">
                                            @if($position->status === 'open')
                                                Close Position
                                            @else
                                                Reopen Position
                                            @endif
                                        </button>
                                    </form>
                                </div>
                                @if($position->description)
                                    <p class="text-gray-600 mb-2">{{ $position->description }}</p>
                                @endif
                                <div class="text-sm text-gray-600">
                                    <span class="font-medium">Positions available:</span> {{ $position->positions_available }}
                                    <span class="mx-2">•</span>
                                    <span class="font-medium">Status:</span>
                                    <span class="px-2 py-1 rounded-full text-xs
                                        @if($position->status === 'open') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($position->status) }}
                                    </span>
                                    <span class="mx-2">•</span>
                                    <span class="font-medium">Created:</span> {{ $position->created_at->format('d.m.Y') }}
                                </div>
                            </div>

                            @if($position->applications->isEmpty())
                                <p class="text-gray-500 italic">No applications yet</p>
                            @else
                                <h3 class="font-semibold mb-3">Applications ({{ $position->applications->count() }})</h3>
                                <div class="space-y-3">
                                    @foreach ($position->applications as $application)
                                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <p class="font-medium">
                                                        {{ $application->applicant->firstname }} {{ $application->applicant->lastname }}
                                                    </p>
                                                    <p class="text-sm text-gray-600">{{ $application->applicant->email }}</p>
                                                </div>
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($application->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($application->status === 'accepted') bg-green-100 text-green-800
                                                    @elseif($application->status === 'rejected') bg-red-100 text-red-800
                                                    @endif">
                                                    {{ ucfirst($application->status) }}
                                                </span>
                                            </div>

                                            @if($application->message)
                                                <div class="mb-3 p-3 bg-white rounded border border-gray-200">
                                                    <p class="text-sm text-gray-700">{{ $application->message }}</p>
                                                </div>
                                            @endif

                                            @if($application->status === 'pending')
                                                <div class="flex gap-2 mt-3">
                                                    <form method="POST" action="{{ route('emner.applications.update', $application->id) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="accepted">
                                                        <button type="submit"
                                                                class="inline-flex items-center px-3 py-1.5 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                            Accept
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('emner.applications.update', $application->id) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit"
                                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                            Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif

                                            <p class="text-xs text-gray-500 mt-2">
                                                Applied: {{ $application->created_at->format('d.m.Y H:i') }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection

