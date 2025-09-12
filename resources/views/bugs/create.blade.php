@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Bug</h2>
    <form method="POST" action="{{ route('bugs.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="attachment" class="form-label">Attachment (PNG, JPG, PDF only)</label>
            <input type="file" class="form-control" id="attachment" name="attachment" accept=".png,.jpg,.jpeg,.pdf">
        </div>
        <div class="mb-3">
            <label for="assigned_to" class="form-label">Assign to Developer</label>
            <select class="form-control" id="assigned_to" name="assigned_to">
                @foreach($devs as $dev)
                <option value="{{ $dev->id }}">{{ $dev->name }} ({{ $dev->email }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Bug</button>
    </form>
</div>
@endsection