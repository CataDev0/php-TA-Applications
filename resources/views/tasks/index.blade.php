@extends('layouts.app')

@section('content')
<h1>Tasks</h1>
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Date/Time</th>
            <th>Pay</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
        <tr>
            <td>{{ $task->title }}</td>
            <td>{{ $task->description }}</td>
            <td>{{ $task->date_time }}</td>
            <td>{{ $task->pay }}</td>
            <td>{{ $task->status }}</td>
            <td>
                @if (auth()->user()->isTA() && $task->status === 'pending' && !$task->ta_id)
                    <form method="POST" action="{{ route('tasks.accept', $task->id) }}">
                        @csrf
                        <button type="submit">Accept</button>
                    </form>
                @endif
                @if ((auth()->user()->id === $task->teacher_id || auth()->user()->id === $task->ta_id) && $task->status !== 'completed')
                    <form method="POST" action="{{ route('tasks.complete', $task->id) }}">
                        @csrf
                        <button type="submit">Mark Complete</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection