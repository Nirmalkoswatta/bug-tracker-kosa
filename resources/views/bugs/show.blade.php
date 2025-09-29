@extends('layouts.app')

@section('content')
<style>
    .bug-details-bg {
        min-height: 100vh;
        width: 100vw;
        display: flex;
        align-items: center;
        justify-content: center;
        background: none;
    }

    .bug-details-card {
        background: rgba(255, 255, 255, 0.97);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.13);
        border-radius: 24px;
        border: 1.5px solid #e5e7eb;
        max-width: 600px;
        width: 100%;
        padding: 2.5rem 2rem 2rem 2rem;
        color: #111;
        margin: 2.5rem 0;
        position: relative;
    }

    .bug-details-title {
        font-size: 2rem;
        font-weight: bold;
        text-align: center;
        margin-bottom: 1.5rem;
        letter-spacing: 1px;
        color: #111;
        text-shadow: none;
    }

    .bug-details-label {
        font-weight: 500;
        color: #222;
        margin-bottom: 0.2rem;
        letter-spacing: 0.5px;
    }

    .bug-details-value {
        color: #111;
        margin-bottom: 1.1rem;
        font-size: 1.08rem;
        word-break: break-word;
    }

    .bug-details-status {
        display: inline-block;
        font-size: 1rem;
        font-weight: 600;
        padding: 0.3em 1em;
        border-radius: 1em;
        background: #f3f4f6;
        color: #111;
        margin-bottom: 0.7rem;
        letter-spacing: 0.5px;
    }

    .bug-details-status.inprogress {
        background: #f1c40f;
        color: #222;
    }

    .bug-details-status.review {
        background: #3498db;
        color: #fff;
    }

    .bug-details-status.done {
        background: #27ae60;
        color: #fff;
    }

    .bug-details-file {
        margin-bottom: 1.2rem;
    }

    .bug-details-file img,
    .bug-details-file embed {
        border-radius: 10px;
        box-shadow: 0 2px 12px #0005;
        max-width: 100%;
        margin-bottom: 0.5rem;
    }

    .bug-details-btns {
        display: flex;
        justify-content: flex-end;
        gap: 0.7rem;
        margin-top: 1.5rem;
    }
</style>
<div class="bug-details-bg">
    <div class="bug-details-card">
        <div class="bug-details-title">Bug Details</div>
        <div class="bug-details-label">Title</div>
        <div class="bug-details-value">{{ $bug->title }}</div>
        <div class="bug-details-label">Description</div>
        <div class="bug-details-value">{{ $bug->description }}</div>
        <div class="bug-details-label">Status</div>
        <div class="bug-details-status {{ strtolower($bug->status) }}">{{ ucfirst($bug->status) }}</div>
        <div class="bug-details-label">Created By</div>
        <div class="bug-details-value">{{ optional($bug->creator)->name ?? '-' }}</div>
        <div class="bug-details-label">Assigned Developer</div>
        <div class="bug-details-value">{{ optional($bug->assignedTo)->name ?? '-' }}</div>
        <div class="bug-details-label">Created At</div>
        <div class="bug-details-value">
            {{ $bug->created_at ? \Carbon\Carbon::parse($bug->created_at)->setTimezone('Asia/Colombo')->format('Y-m-d h:i A') : '-' }}
        </div>
        @if($bug->attachment)
        @php
        $ext = strtolower(pathinfo($bug->attachment, PATHINFO_EXTENSION));
        $imgExts = ['jpg','jpeg','png','gif','bmp','webp'];
        @endphp
        <div class="bug-details-label">Attachment</div>
        <div class="bug-details-file">
            @if(in_array($ext, $imgExts))
            <img src="{{ asset('storage/' . $bug->attachment) }}" alt="Attachment Image">
            @elseif($ext === 'pdf')
            <embed src="{{ asset('storage/' . $bug->attachment) }}" type="application/pdf" width="100%" height="400px" style="background:#222;" />
            @else
            <a href="{{ asset('storage/' . $bug->attachment) }}" target="_blank" class="btn btn-info btn-sm">View File</a>
            @endif
            <a href="{{ route('bugs.download', $bug) }}" class="btn btn-success btn-sm ms-2">Download</a>
        </div>
        @endif
        <div class="bug-details-btns">
            <button type="button" class="btn btn-outline-light" style="border-radius:18px;" onclick="window.history.back();">Cancel</button>
            @if(Auth::user()->role === 'QA' && $bug->created_by === Auth::id())
            <form method="POST" action="{{ route('bugs.destroy', $bug) }}" onsubmit="return confirm('Are you sure you want to delete this bug?');" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="border-radius:18px;">Delete Bug</button>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection