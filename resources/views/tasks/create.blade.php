@extends('layouts.app')

@section('content')
<h1>Create New Task</h1>
<form method="POST" action="{{ route('tasks.store') }}">
    @csrf
    <label>Title:</label>
    <input type="text" name="title" required>
    <br>
    <label>Description:</label>
    <textarea name="description"></textarea>
    <br>
    <label>Date/Time:</label>
    <input type="datetime-local" name="date_time">
    <br>
    <label>Pay:</label>
    <input type="number" name="pay" step="0.01">
    <br>
    <label>Urgency:</label>
    <input type="text" name="urgency">
    <br>
    <button type="submit">Create Task</button>
</form>
@endsection