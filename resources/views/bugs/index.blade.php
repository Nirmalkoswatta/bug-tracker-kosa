@extends('layouts.app')

@section('content')
<style>
    .bug-cards-bg {
        min-height: 100vh;
        padding: 2rem 0;
    }

    .bug-card-glass {
        background: rgba(255, 255, 255, 0.10);
        backdrop-filter: blur(10px) saturate(140%);
        -webkit-backdrop-filter: blur(10px) saturate(140%);
        border-radius: 18px;
        border: 1px solid rgba(255, 255, 255, 0.22);
        box-shadow: 0 4px 18px -2px rgba(0, 0, 0, 0.25);
        transition: transform .15s, box-shadow .15s;
    }

    .bug-card-glass:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 8px 32px -4px rgba(0, 0, 0, 0.35);
    }

    .bug-status {
        font-size: 0.85rem;
        padding: 0.3em 0.9em;
        border-radius: 1em;
        font-weight: 600;
        letter-spacing: .5px;
    }

    .bug-status-open {
        background: #e74c3c;
        color: #fff;
    }

    .bug-status-inprogress {
        background: #f1c40f;
        color: #222;
    }

    .bug-status-done {
        background: #27ae60;
        color: #fff;
    }

    .bug-meta-label {
        color: #bbb;
        font-size: 0.92em;
    }

    .bug-action-btn {
        min-width: 70px;
    }
</style>
<div class="bug-cards-bg" style="background: url('{{ asset('10780356_19199649.jpg') }}') no-repeat center center fixed; background-size: cover;">
    <div class="container">
        <h2 class="text-white mb-4">All Bugs</h2>
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(in_array(Auth::user()->role,['QA','Admin']))
        <a href="{{ route('bugs.create') }}" class="btn btn-primary mb-3">Create Bug</a>
        @endif
        @if($bugs->count())
        <div class="row g-4">
            @foreach($bugs as $bug)
            @php
            $status = strtolower($bug->status ?? '');
            $statusClass = match($status) {
            'open' => 'bug-status bug-status-open',
            'in progress', 'in_progress' => 'bug-status bug-status-inprogress',
            'done' => 'bug-status bug-status-done',
            default => 'bug-status bg-secondary text-white'
            };
            @endphp
            <div class="col-12 col-md-6 col-lg-4">
                <div class="bug-card-glass p-4 h-100 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold fs-5" style="color:#fff;">{{ $bug->title }}</span>
                        <span class="{{ $statusClass }}">{{ ucfirst($status) }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="bug-meta-label">ID:</span> <span style="color:#fff;">{{ $bug->id }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="bug-meta-label">QA (Creator):</span>
                        <span style="color:#fff;">
                            @php
                            $creator = $bug->qa_creator ?? $bug->creator ?? null;
                            $creatorName = is_object($creator) ? ($creator->name ?? '-') : (is_array($creator) ? ($creator['name'] ?? '-') : (is_string($creator) ? $creator : '-'));
                            $createdAt = $bug->created_at
                            ? \Carbon\Carbon::parse($bug->created_at)
                            ->setTimezone('Asia/Colombo')
                            ->format('Y-m-d h:i A')
                            : '-';
                            @endphp
                            {{ $creatorName }} <span class="bug-meta-label">|</span> {{ $createdAt }}
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="bug-meta-label">Assigned Dev:</span> <span style="color:#fff;">{{ $bug->assigned_dev ?? (optional($bug->assignedTo)->name ?? '-') }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="bug-meta-label">Description:</span>
                        <div class="small" style="color:#fff;">{{ Str::limit($bug->description, 80) }}</div>
                    </div>
                    <div class="mt-auto d-flex gap-2">
                        @if($bug->attachment)
                        <a href="{{ route('bugs.download', $bug) }}" class="btn btn-info btn-sm bug-action-btn text-white">Download</a>
                        @else
                        <button type="button" class="btn btn-info btn-sm bug-action-btn text-white" disabled>View</button>
                        @endif
                        @if(Route::has('bugs.edit'))
                        <a href="{{ route('bugs.edit', $bug->id) }}" class="btn btn-primary btn-sm bug-action-btn">Edit</a>
                        @endif
                        @if(Route::has('bugs.destroy'))
                        <form action="{{ route('bugs.destroy', $bug->id) }}" method="POST" onsubmit="return confirm('Delete bug #{{ $bug->id }}?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm bug-action-btn">Delete</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="alert alert-light mt-5">No bugs found.</div>
        @endif
    </div>
</div>
@endsection