@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Bug List</h2>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('bugs.create') }}" class="btn btn-primary mb-3">Create Bug</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bugs as $bug)
            <tr>
                <td>{{ $bug->id }}</td>
                <td>{{ $bug->title }}</td>
                <td>{{ $bug->status }}</td>
                <td>{{ optional($bug->assignedTo)->name }}</td>
                <td>
                    <a href="{{ route('bugs.show', $bug) }}" class="btn btn-info btn-sm">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection