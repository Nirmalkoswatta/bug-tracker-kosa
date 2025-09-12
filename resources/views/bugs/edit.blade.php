@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Bug</h2>
    <form method="POST" action="{{ route('bugs.update', $bug) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $bug->title }}" readonly>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" readonly>{{ $bug->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="inprogress" {{ $bug->status == 'inprogress' ? 'selected' : '' }}>In Progress</option>
                <option value="review" {{ $bug->status == 'review' ? 'selected' : '' }}>Review</option>
            </select>
        </div>
        @if(Auth::user()->role === 'Dev' && Auth::user()->can_access_qas && $bug->reviewed_by)
        <div class="mb-3">
            <label class="form-label">QA Assigned:</label>
            <span>{{ optional($bug->reviewedBy)->name }}</span>
        </div>
        @endif
        @if($bug->attachment)
        <div class="mb-3">
            <label class="form-label">QA Uploaded File:</label>
            <a href="{{ asset('storage/' . $bug->attachment) }}" target="_blank" class="btn btn-info btn-sm">View</a>
            @if(Auth::user()->role === 'QA')
                <a href="{{ route('bugs.edit', $bug) }}?editfile=1" class="btn btn-secondary btn-sm">Edit/Update File</a>
            @endif
        </div>
        @endif
        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>
</div>
@endsection
