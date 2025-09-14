@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Bug List</h2>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(in_array(Auth::user()->role,['QA','Admin']))
    <a href="{{ route('bugs.create') }}" class="btn btn-primary mb-3">Create Bug</a>
    @endif
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
                    <a href="{{ route('bugs.edit', $bug) }}" class="btn btn-info btn-sm">View</a>
                    @if(Auth::user()->role === 'QA' && $bug->status === 'done' && $bug->created_by === Auth::id())
                    <form action="{{ route('bugs.destroy', $bug) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this bug?')">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection