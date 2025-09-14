@extends('layouts.app')

@section('content')
<div class="container admin-dashboard-root" style="margin-top:110px; max-width:1400px;">
    <div class="text-center mb-5">
        <h2 class="fw-bold page-title text-white" style="letter-spacing:1px;">Admin Dashboard</h2>
        <p class="mb-0 subtitle text-white-50">Manage users, permissions & monitor reported bugs</p>
    </div>

    <!-- KPI Metrics Bar -->
    <div class="row g-4 kpi-metrics mb-5">
        <div class="col-6 col-md-3">
            <div class="kpi-tile fade-in-stagger" style="--stagger-index:0;">
                <span class="kpi-label">Total Bugs</span>
                <span class="kpi-value" data-count="{{ $bugs->count() }}">0</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-tile fade-in-stagger" style="--stagger-index:1;">
                <span class="kpi-label">Open</span>
                <span class="kpi-value" data-count="{{ $bugs->where('status','open')->count() }}">0</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-tile fade-in-stagger" style="--stagger-index:2;">
                <span class="kpi-label">In Progress</span>
                <span class="kpi-value" data-count="{{ $bugs->where('status','in_progress')->count() }}">0</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-tile fade-in-stagger" style="--stagger-index:3;">
                <span class="kpi-label">Done</span>
                <span class="kpi-value" data-count="{{ $bugs->where('status','done')->count() }}">0</span>
            </div>
        </div>
    </div>

    <div class="dashboard-cards-row mb-4" data-stagger-parent>
        <!-- Developers Card -->
        <div class="dashboard-card stagger-up" style="--stagger-index:0;">
            <h4 class="bg-primary text-white p-2 rounded w-100 text-center">Developers <span class="badge bg-light text-dark ms-2">{{ $developers->count() }}</span></h4>
            <div class="table-responsive w-100 subtle-scroll">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="d-none d-md-table-cell">Email</th>
                            <th>QA</th>
                            <th>Toggle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($developers as $dev)
                        <tr>
                            <td>{{ $dev->name }}</td>
                            <td class="d-none d-md-table-cell small">{{ $dev->email }}</td>
                            <td>
                                @if($dev->can_access_qas)
                                <span class="badge access-badge yes">YES</span>
                                @else
                                <span class="badge access-badge no">NO</span>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.toggleQAs', $dev->id) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm toggle-btn {{ $dev->can_access_qas ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                        {{ $dev->can_access_qas ? 'Revoke' : 'Grant' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center small">No developers registered.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- QAs Card -->
        <div class="dashboard-card stagger-up" style="--stagger-index:1;">
            <h4 class="bg-success text-white p-2 rounded w-100 text-center">QAs <span class="badge bg-light text-dark ms-2">{{ $qas->count() }}</span></h4>
            <div class="table-responsive w-100 subtle-scroll">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="d-none d-md-table-cell">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($qas as $qa)
                        <tr>
                            <td>{{ $qa->name }}</td>
                            <td class="d-none d-md-table-cell small">{{ $qa->email }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center small">No QAs registered.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PMs Card -->
        <div class="dashboard-card stagger-up" style="--stagger-index:2; ">
            <h4 class="bg-warning text-dark p-2 rounded w-100 text-center">Project Managers <span class="badge bg-light text-dark ms-2">{{ $pms->count() }}</span></h4>
            <div class="table-responsive w-100 subtle-scroll">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="d-none d-md-table-cell">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pms as $pm)
                        <tr>
                            <td>{{ $pm->name }}</td>
                            <td class="d-none d-md-table-cell small">{{ $pm->email }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center small">No project managers registered.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="dashboard-bug-table mt-4 stagger-up" style="--stagger-index:3;">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <h4 class="mb-0 fw-semibold">All Reported Bugs ({{ $bugs->count() }})</h4>
            <a href="{{ route('bugs.create') }}" class="btn btn-primary btn-sm create-btn">Create Bug</a>
        </div>
        <div class="table-responsive subtle-scroll-x">
            <div class="scroll-fade left"></div>
            <div class="scroll-fade right"></div>
            <table class="table table-hover table-bordered align-middle mb-0 small bug-table">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Assigned Dev</th>
                        <th>Created By</th>
                        <th>Attachment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bugs as $bug)
                    <tr>
                        <td>{{ $bug->id }}</td>
                        <td class="text-truncate" style="max-width:220px;">{{ $bug->title }}</td>
                        <td>
                            <span class="status-badge status-{{ $bug->status }}">{{ $bug->status }}</span>
                        </td>
                        <td>{{ optional($bug->assignedTo)->name ?? '—' }}</td>
                        <td>{{ optional($bug->creator)->name ?? '—' }}</td>
                        <td>
                            @if($bug->attachment)
                            <span class="badge bg-secondary">Restricted</span>
                            @else
                            <span class="text-muted">None</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No bugs reported.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /******** Layout tweaks ********/
    .admin-dashboard-root {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    @media (max-width:576px) {
        .admin-dashboard-root {
            margin-top: 100px !important;
        }
    }

    .page-title {
        font-size: clamp(1.6rem, 2.2vw, 2.2rem);
    }

    .subtitle {
        font-size: clamp(.8rem, 1.1vw, .95rem);
    }

    /******** Stagger animations ********/
    .stagger-up {
        opacity: 0;
        transform: translateY(32px);
        animation: staggerUp .75s cubic-bezier(.4, 1.6, .4, 1) forwards;
        animation-delay: calc(var(--stagger-index, 0) * 130ms);
    }

    @keyframes staggerUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /******** KPI Tiles (kept) ********/
    .kpi-tile {
        position: relative;
        background: linear-gradient(135deg, #ffffff 10%, #f1f5f9 90%);
        border-radius: 18px;
        padding: 18px 18px 14px;
        box-shadow: 0 4px 18px rgba(31, 38, 135, 0.12);
        overflow: hidden;
        isolation: isolate;
    }

    .kpi-tile::before {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 20% 15%, rgba(99, 102, 241, 0.25), transparent 60%), radial-gradient(circle at 85% 70%, rgba(236, 72, 153, 0.25), transparent 55%);
        opacity: 0.9;
        mix-blend-mode: overlay;
    }

    .kpi-label {
        display: block;
        font-size: .65rem;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #334155;
        margin-bottom: 4px;
    }

    .kpi-value {
        font-size: 1.9rem;
        font-weight: 700;
        letter-spacing: .5px;
        background: linear-gradient(90deg, #6366f1, #ec4899 60%, #f59e0b);
        -webkit-background-clip: text;
        color: transparent;
        display: inline-block;
    }

    /******** Cards ********/
    .dashboard-cards-row {
        display: flex;
        justify-content: center;
        gap: 32px;
        flex-wrap: wrap;
    }

    .dashboard-card {
        background: linear-gradient(135deg, #f8fafc 60%, #e0e7ef 100%);
        border-radius: 22px;
        box-shadow: 0 6px 32px rgba(31, 38, 135, 0.13);
        padding: 28px 20px 18px;
        width: 340px;
        min-width: 280px;
        max-width: 100%;
        min-height: 320px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        position: relative;
        overflow: hidden;
        transition: transform .25s cubic-bezier(.4, 2, .3, 1), box-shadow .25s cubic-bezier(.4, 2, .3, 1);
    }

    .dashboard-card:hover {
        transform: translateY(-10px) scale(1.035);
        box-shadow: 0 18px 48px rgba(31, 38, 135, 0.19);
    }

    .dashboard-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, rgba(0, 153, 255, 0.12) 0%, rgba(255, 255, 255, 0) 70%);
        opacity: 0;
        transition: opacity .35s;
        border-radius: inherit;
    }

    .dashboard-card:hover::before {
        opacity: 1;
    }

    .dashboard-card h4 {
        font-weight: 700;
        margin-bottom: 14px;
        letter-spacing: .5px;
        font-size: 1.05rem;
    }

    .dashboard-card table thead th {
        font-size: .62rem;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .dashboard-card table tbody td {
        font-size: .7rem;
    }

    .toggle-btn:focus-visible,
    .create-btn:focus-visible {
        outline: 2px solid #6366f1;
        outline-offset: 2px;
    }

    /******** Access badges ********/
    .access-badge {
        font-size: .55rem;
        letter-spacing: .08em;
        padding: 4px 6px;
        border-radius: 30px;
        font-weight: 600;
    }

    .access-badge.yes {
        background: linear-gradient(90deg, #16a34a, #4ade80);
        color: #fff;
    }

    .access-badge.no {
        background: linear-gradient(90deg, #64748b, #94a3b8);
        color: #fff;
    }

    /******** Status badges ********/
    .status-badge {
        display: inline-block;
        font-size: .55rem;
        padding: 6px 10px;
        border-radius: 30px;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        background: #64748b;
        color: #fff;
    }

    .status-badge.status-open {
        background: linear-gradient(90deg, #f97316, #fb923c);
    }

    .status-badge.status-in_progress {
        background: linear-gradient(90deg, #0ea5e9, #38bdf8);
    }

    .status-badge.status-done {
        background: linear-gradient(90deg, #059669, #34d399);
    }

    /******** Bug table ********/
    .dashboard-bug-table {
        background: #fffffffa;
        backdrop-filter: blur(10px);
        border-radius: 18px;
        box-shadow: 0 4px 28px rgba(31, 38, 135, 0.12);
        padding: 24px 18px 20px;
        animation: fadeInUp .7s cubic-bezier(.4, 2, .3, 1);
        position: relative;
        overflow: hidden;
    }

    .bug-table tbody tr {
        transition: background .2s;
    }

    .bug-table tbody tr:hover {
        background: rgba(99, 102, 241, 0.07);
    }

    /******** Scroll fade indicators ********/
    .subtle-scroll {
        max-height: 260px;
        overflow: auto;
        scrollbar-width: thin;
    }

    .subtle-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .subtle-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .subtle-scroll::-webkit-scrollbar-thumb {
        background: linear-gradient(#cbd5e1, #94a3b8);
        border-radius: 4px;
    }

    .subtle-scroll-x {
        position: relative;
    }

    .subtle-scroll-x .scroll-fade {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 36px;
        pointer-events: none;
        z-index: 3;
    }

    .subtle-scroll-x .scroll-fade.left {
        left: 0;
        background: linear-gradient(90deg, #fffffffa, rgba(255, 255, 255, 0));
    }

    .subtle-scroll-x .scroll-fade.right {
        right: 0;
        background: linear-gradient(-90deg, #fffffffa, rgba(255, 255, 255, 0));
    }

    .subtle-scroll-x>.table {
        margin-bottom: 0;
    }

    /******** Utilities ********/
    .text-truncate {
        max-width: 220px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    @media (max-width: 992px) {
        .dashboard-cards-row {
            gap: 22px;
        }
    }

    @media (max-width: 768px) {
        .dashboard-card {
            width: 100%;
            min-width: 100%;
        }

        .dashboard-cards-row {
            gap: 18px;
        }
    }

    @media (max-width: 576px) {
        .kpi-value {
            font-size: 1.5rem;
        }

        .status-badge {
            font-size: .5rem;
            padding: 5px 8px;
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Title/subtitle overrides */
    .page-title { color:#ffffff !important; }
    .subtitle { color:rgba(255,255,255,0.75) !important; }
    .kpi-label { color:rgba(255,255,255,0.8) !important; }

    /* Ensure KPI tile background adapts on dark gradient parent */
    .kpi-tile { backdrop-filter:blur(4px); }
</style>
@endpush

@push('scripts')
<script>
    // Extend existing counters & add stagger reveal for cards after DOM ready
    (function() {
        const root = document.querySelector('.admin-dashboard-root');
        const kpis = root.querySelectorAll('.kpi-value');
        const easeOut = t => 1 - Math.pow(1 - t, 3);

        function animateCount(el) {
            const target = parseInt(el.dataset.count || '0', 10);
            if (!target) {
                el.textContent = '0';
                return;
            }
            const dur = 900 + Math.min(1200, target * 12);
            const start = performance.now();

            function frame(now) {
                const p = Math.min(1, (now - start) / dur);
                const val = Math.floor(easeOut(p) * target);
                el.textContent = val.toLocaleString();
                if (p < 1) requestAnimationFrame(frame);
                else el.classList.add('pulse');
            }
            requestAnimationFrame(frame);
        }
        if ('IntersectionObserver' in window) {
            const io = new IntersectionObserver(entries => {
                entries.forEach(e => {
                    if (e.isIntersecting) {
                        animateCount(e.target);
                        io.unobserve(e.target);
                    }
                });
            }, {
                threshold: .55
            });
            kpis.forEach(k => io.observe(k));
        } else {
            kpis.forEach(k => k.textContent = k.dataset.count);
        }

        // Horizontal scroll fade dynamic visibility
        document.querySelectorAll('.subtle-scroll-x').forEach(wrap => {
            const leftF = wrap.querySelector('.scroll-fade.left');
            const rightF = wrap.querySelector('.scroll-fade.right');

            function update() {
                const el = wrap.querySelector('table');
                const maxScroll = el.scrollWidth - el.clientWidth;
                const sc = wrap.scrollLeft;
                leftF.style.opacity = sc > 5 ? 1 : 0;
                rightF.style.opacity = sc < maxScroll - 5 ? 1 : 0;
            }
            wrap.addEventListener('scroll', update, {
                passive: true
            });
            window.addEventListener('resize', update);
            setTimeout(update, 100);
        });
    })();
</script>
@endpush