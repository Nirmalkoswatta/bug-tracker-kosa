@extends('layouts.app')

@section('content')
<div class="container">
    <h2>View & Edit Bug</h2>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('bugs.update', $bug) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $bug->title }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $bug->description }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <input type="text" class="form-control" value="{{ $bug->status }}" readonly>
        </div>
        <button type="submit" class="btn btn-primary">Update Bug</button>
    </form>
    @if(Auth::user()->role === 'QA' && $bug->created_by === Auth::id())
    <form method="POST" action="{{ route('bugs.destroy', $bug) }}" onsubmit="return confirm('Are you sure you want to delete this bug?');" style="display:inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger mt-3">Delete Bug</button>
    </form>
    @endif
</div>
@endsection