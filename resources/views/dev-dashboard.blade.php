@extends('layouts.app')

@section('content')
<style>
    /* Layout container */
    .dev-dashboard-bg {
        margin-top: 90px;
        min-height: calc(100vh - 90px);
        width: 100%;
        background: #f7f7f9;
        color: #111;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 2rem 1rem 3rem;
    }

    .dev-dashboard-title {
        font-size: 2.15rem;
        font-weight: 800;
        margin: 0 0 2rem 0;
        text-align: center;
        letter-spacing: .5px;
        color: #111;
    }

    /* Card grid */
    .dev-bug-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 1.6rem;
        justify-content: center;
        width: 100%;
        max-width: 1260px;
    }

    .dev-bug-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 22px;
        min-width: 270px;
        max-width: 340px;
        width: 100%;
        padding: 1.4rem 1.15rem 1.25rem;
        color: #111;
        display: flex;
        flex-direction: column;
        gap: .55rem;
        position: relative;
        box-shadow: 0 6px 18px -4px rgba(0, 0, 0, .08), 0 2px 4px -2px rgba(0, 0, 0, .05);
        transition: transform .18s ease, box-shadow .18s ease;
    }

    .dev-bug-card:before {
        content: "";
        position: absolute;
        inset: 0;
        pointer-events: none;
        background: radial-gradient(circle at 18% 20%, rgba(99, 102, 241, .08), transparent 60%), radial-gradient(circle at 80% 75%, rgba(236, 72, 153, .09), transparent 62%);
    }

    .dev-bug-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px -6px rgba(0, 0, 0, .18);
    }

    .dev-bug-id {
        font-size: .95rem;
        font-weight: 600;
        color: #334155;
        letter-spacing: .5px;
    }

    .dev-bug-title {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: .1rem;
        color: #111;
    }

    /* Status badge */
    .dev-bug-status {
        display: inline-block;
        font-size: .65rem;
        font-weight: 700;
        padding: .4em .85em;
        border-radius: 2em;
        letter-spacing: .08em;
        text-transform: uppercase;
        background: #111;
        color: #fff;
    }

    .dev-bug-status.inprogress {
        background: linear-gradient(90deg, #f59e0b, #fbbf24);
        color: #111;
    }

    .dev-bug-status.review {
        background: linear-gradient(90deg, #4f46e5, #6366f1);
        color: #fff;
    }

    .dev-bug-status.done {
        background: linear-gradient(90deg, #059669, #34d399);
        color: #fff;
    }

    /* Actions */
    .dev-bug-actions {
        margin-top: .75rem;
        display: flex;
        justify-content: flex-end;
        gap: .55rem;
    }

    .dev-bug-btn {
        font-size: .7rem;
        font-weight: 600;
        border: 2px solid #111;
        background: #fff;
        color: #111;
        padding: .5rem 1rem;
        border-radius: 1rem;
        letter-spacing: .5px;
        cursor: pointer;
        transition: .18s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: .35rem;
    }

    /* Severity badge (dev dashboard) */
    .sev-line {
        margin-top: .25rem;
    }

    .sev-tag {
        font-size: .7rem;
        font-weight: 700;
        border-radius: 999px;
        padding: .25rem .6rem;
    }

    .sev-badge {
        padding: .2rem .5rem;
        border-radius: 999px;
        font-weight: 700;
    }

    .sev-low {
        background: #dcfce7;
        color: #166534;
    }

    .sev-medium {
        background: #ffedd5;
        color: #c2410c;
    }

    .sev-high {
        background: #fee2e2;
        color: #b91c1c;
    }

    .dev-bug-btn:hover {
        background: #111;
        color: #fff;
    }

    .dev-bug-btn.primary {
        background: #111;
        color: #fff;
    }

    .dev-bug-btn.primary:hover {
        background: #222;
    }

    /* Responsive */
    @media (max-width:700px) {
        .dev-bug-cards {
            gap: 1.1rem;
        }

        .dev-bug-card {
            min-width: 92vw;
            max-width: 96vw;
        }
    }
</style>
<div class="dev-dashboard-bg">
    <div class="dev-dashboard-title">Developer Dashboard</div>
    <div class="dev-bug-cards">
        @foreach($bugs as $bug)
        <div class="dev-bug-card">
            <div class="dev-bug-id">#{{ $bug->id }}</div>
            <div class="dev-bug-title">{{ $bug->title }}</div>
            <div class="dev-bug-status {{ strtolower($bug->status) }}">{{ ucfirst($bug->status) }}</div>
            @php
            $sev = strtolower($bug->severity ?? 'low');
            $sevStyle = $sev==='high'
            ? 'background:#fee2e2;color:#b91c1c'
            : ($sev==='medium' ? 'background:#ffedd5;color:#c2410c' : 'background:#dcfce7;color:#166534');
            @endphp
            <div class="sev-line">
                <span class="sev-tag">Severity:
                    <span class="sev-badge {{ 'sev-' . $sev }}">{{ ucfirst($sev) }}</span>
                </span>
            </div>
            <div class="dev-bug-actions">
                @if($bug->attachment)
                <a href="{{ route('bugs.download', $bug) }}" class="dev-bug-btn" title="Download attachment">📎 Download</a>
                @endif
                <a href="{{ route('bugs.edit', $bug) }}" class="dev-bug-btn primary" title="Update bug status">✏️ Update Status</a>
            </div>
            <!-- (Removed legacy bootstrap modal markup for lighter, clean black-text style) -->
        </div>
        @endforeach
    </div>
</div>
@endsection