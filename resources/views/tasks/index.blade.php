@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4 ml-4">Tasks</h1>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-3 px-6 text-left font-semibold text-gray-700">Title</th>
                <th class="py-3 px-6 text-left font-semibold text-gray-700">Description</th>
                <th class="py-3 px-6 text-left font-semibold text-gray-700">Teacher</th>
                <th class="py-3 px-6 text-left font-semibold text-gray-700">Date</th>
                <th class="py-3 px-6 text-left font-semibold text-gray-700">Status</th>
                <th class="py-3 px-6 text-left font-semibold text-gray-700">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-2 px-6">{{ $task->title }}</td>
                <td class="py-2 px-6">{{ $task->description }}</td>
                <td class="py-2 px-6">{{ $task->teacher->firstname }} {{ $task->teacher->lastname }}</td>
                <td class="py-2 px-6">{{ $task->date_time }}</td>
                <td class="py-2 px-6">
                    <span class="
                        px-2 py-1 rounded text-xs font-medium
                        @if($task->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($task->status === 'accepted') bg-blue-100 text-blue-800
                        @elseif($task->status === 'completed') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-700 @endif
                    ">
                        {{ ucfirst($task->status) }}
                    </span>
                </td>
                <td class="py-2 px-6 space-x-2">
                    @if (auth()->user()?->isTA() && $task->status === 'pending' && !$task->ta_id)
                        <form method="POST" action="{{ route('tasks.accept', $task->id) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded transition">
                                Accept
                            </button>
                        </form>
                    @endif
                    @if ((auth()->user()?->id === $task->teacher_id || auth()->user()?->id === $task->ta_id) && $task->status !== 'completed')
                        <form method="POST" action="{{ route('tasks.complete', $task->id) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded transition">
                                Mark Complete
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
