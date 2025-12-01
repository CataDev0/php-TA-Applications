@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold">Open TA Positions</h1>
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Back to Dashboard
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-md">
                        {{ session('error') }}
                    </div>
                @endif

                @if($positions->isEmpty())
                    <p class="text-gray-600 text-center py-8">No open TA positions available at the moment.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($positions as $position)
                            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                                <h3 class="text-lg font-semibold mb-2">{{ $position->emne }}</h3>

                                @if($position->description)
                                    <p class="text-gray-600 text-sm mb-4">{{ $position->description }}</p>
                                @endif

                                <div class="mb-4 text-sm text-gray-600">
                                    <p><strong>Positions available:</strong> {{ $position->positions_available }}</p>
                                    <p><strong>Applications:</strong> {{ $position->applications->count() }}</p>
                                </div>

                                @php
                                    $userApplication = $position->applications->first();
                                @endphp

                                @if($userApplication)
                                    <div class="mt-4">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if($userApplication->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($userApplication->status === 'accepted') bg-green-100 text-green-800
                                            @elseif($userApplication->status === 'rejected') bg-red-100 text-red-800
                                            @endif">
                                            Application: {{ ucfirst($userApplication->status) }}
                                        </span>
                                    </div>
                                @else
                                    <button
                                        onclick="openApplyModal({{ $position->id }}, '{{ addslashes($position->emne) }}')"
                                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Apply Now
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Application Modal -->
    <div id="applyModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Apply for TA Position</h3>
                <p class="text-sm text-gray-600 mb-4">Position: <strong id="modalEmne"></strong></p>

                <form id="applyForm" method="POST" action="">
                    @csrf
                    <div class="mb-4">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            Application Message (Optional)
                        </label>
                        <textarea
                            name="message"
                            id="message"
                            rows="4"
                            placeholder="Tell us why you'd be a great fit..."
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Submit Application
                        </button>
                        <button type="button"
                                onclick="closeApplyModal()"
                                class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openApplyModal(positionId, emne) {
            document.getElementById('modalEmne').textContent = emne;
            document.getElementById('applyForm').action = `/ta-positions/${positionId}/apply`;
            document.getElementById('applyModal').classList.remove('hidden');
        }

        function closeApplyModal() {
            document.getElementById('applyModal').classList.add('hidden');
            document.getElementById('message').value = '';
        }

        // Close modal when clicking outside
        document.getElementById('applyModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeApplyModal();
            }
        });
    </script>
@endsection

