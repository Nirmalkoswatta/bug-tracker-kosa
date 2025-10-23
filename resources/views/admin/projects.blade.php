@extends('layouts.app')
@section('content')
<h4 class="mb-3">Projects</h4>
<div class="card-grid">
    @forelse($projects as $p)
    <div class="ui-card">
        <div class="d-flex justify-content-between">
            <strong>{{ $p->name }}</strong>
            <span class="badge text-bg-info">{{ $p->open_bugs ?? 0 }} bugs</span>
        </div>
        <div class="mt-2 small text-muted">PM: {{ optional($p->pm)->name ?? '—' }}</div>
        <div class="progress mt-2" style="height:8px"><span data-progress="{{ (int)($p->progress ?? 35) }}" style="display:block;height:100%;background:linear-gradient(90deg,#14b8a6,#22d3ee)"></span></div>
        <div class="mt-2 d-flex gap-2">
            <a href="#" class="btn btn-sm btn-outline-primary">Open</a>
            <a href="#" class="btn btn-sm btn-outline-secondary">Manage</a>
        </div>
    </div>
    @empty
    <div class="ui-card">No projects found.</div>
    @endforelse
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[data-progress]').forEach(function(el) {
            var v = parseInt(el.getAttribute('data-progress') || '0', 10);
            v = Math.max(0, Math.min(100, v));
            el.style.width = v + '%';
        });
    });
</script>
@endpush
@endsection