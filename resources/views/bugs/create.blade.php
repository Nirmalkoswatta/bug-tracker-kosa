@extends('layouts.app')

@section('content')
<style>
    /* Scoped styling for this create bug page */
    .create-bug-wrapper {
        min-height: calc(100vh - 120px);
    }

    .bug-create-panel {
        background: rgba(255, 255, 255, 0.10);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 20px;
        padding: 2.25rem 2.25rem 2rem;
        width: 100%;
        max-width: 640px;
        box-shadow: 0 8px 24px -4px rgba(0, 0, 0, 0.45);
        position: relative;
    }

    .bug-create-panel h2 {
        font-weight: 600;
        letter-spacing: .5px;
    }

    .bug-create-panel h2,
    .bug-create-panel .form-label {
        color: #111 !important;
    }

    .bug-create-panel .form-control {
        color: #111;
        background: #fff;
    }

    .bug-create-panel .alert {
        color: #0c5460;
    }

    .bug-create-panel .divider-line {
        height: 1px;
        background: linear-gradient(90deg, transparent, #ffffff55, transparent);
        margin: 0.75rem 0 1.25rem;
    }

    @media (max-width: 575.98px) {
        .bug-create-panel {
            padding: 1.75rem 1.5rem 1.25rem;
            border-radius: 16px;
        }
    }
</style>
<div class="create-bug-wrapper d-flex justify-content-center align-items-center px-3">
    <div class="bug-create-panel">
        <h2 class="mb-2">Create Bug</h2>
        <div class="divider-line"></div>
        @if(Auth::user()->role==='Admin')
        <div class="alert alert-info py-2 px-3 mb-4">You are creating a bug as <strong>Admin</strong>. This will be visible to all relevant roles.</div>
        @endif
        <form method="POST" action="{{ route('bugs.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4"></textarea>
            </div>
            <div class="mb-3">
                <label for="severity" class="form-label">Severity</label>
                <select class="form-control" id="severity" name="severity">
                    <option value="low" selected>Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="attachment" class="form-label">Attachment (PNG, JPG, PDF only)</label>
                <input type="file" class="form-control" id="attachment" name="attachment" accept=".png,.jpg,.jpeg,.pdf">
            </div>
            <div class="mb-4">
                <label for="assigned_to" class="form-label">Assign to Developer @if(Auth::user()->role!=='Admin')<span class="text-danger">*</span>@endif</label>
                <select class="form-control" id="assigned_to" name="assigned_to" @if(Auth::user()->role!=='Admin') required @endif>
                    <option value="">-- Select Developer --</option>
                    @foreach($devs as $dev)
                    <option value="{{ $dev->id }}">{{ $dev->name }} ({{ $dev->email }})</option>
                    @endforeach
                </select>
            </div>
            @if(Auth::user()->role==='Admin')
            <div class="mb-4">
                <label for="qa_reviewer" class="form-label">Assign QA Reviewer (optional)</label>
                <select class="form-control" id="qa_reviewer" name="qa_reviewer">
                    <option value="">-- Select QA --</option>
                    @foreach(($qas ?? collect()) as $qa)
                    <option value="{{ $qa->id }}">{{ $qa->name }} ({{ $qa->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="pm_id" class="form-label">Assign Project Manager (optional)</label>
                <select class="form-control" id="pm_id" name="pm_id">
                    <option value="">-- Select PM --</option>
                    @foreach(($pms ?? collect()) as $pm)
                    <option value="{{ $pm->id }}">{{ $pm->name }} ({{ $pm->email }})</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-outline-light" style="--bs-btn-color:#fff; --bs-btn-border-color:#ffffff55; --bs-btn-hover-bg:#ffffff22;">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">Create Bug</button>
            </div>
        </form>
    </div>
</div>
@endsection