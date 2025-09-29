@extends('layouts.app')
@section('content')
<style>
    :root {
        --sidebar-w: 280px;
        --bg: #0f172a;
        --bg-2: #1e293b;
        --card: #fff;
        --teal: #14b8a6;
        --warn: #f97316;
        --danger: #ef4444;
        --shadow: 0 12px 30px -8px rgba(0, 0, 0, .35)
    }

    body {
        font-family: 'Inter', 'Poppins', system-ui, sans-serif;
        background: var(--bg) !important;
    }

    .shell {
        display: flex;
        gap: 0;
        min-height: calc(100vh - 120px);
    }

    .sidebar {
        width: var(--sidebar-w);
        background: var(--bg-2);
        border-right: 1px solid rgba(255, 255, 255, .08);
        position: sticky;
        top: 70px;
        height: calc(100vh - 70px);
    }

    .sb-head {
        padding: 14px 16px;
        color: #fff;
        font-weight: 700;
        border-bottom: 1px solid rgba(255, 255, 255, .08)
    }

    .sb-link {
        display: flex;
        align-items: center;
        gap: .6rem;
        padding: .7rem 1rem;
        color: #cbd5e1;
        text-decoration: none;
        transition: .2s;
        border-left: 3px solid transparent
    }

    .sb-link:hover {
        background: rgba(255, 255, 255, .06);
        color: #fff
    }

    .sb-link.active {
        color: var(--teal);
        background: rgba(20, 184, 166, .12);
        border-left-color: var(--teal)
    }

    .main {
        flex: 1;
        padding: 20px;
    }

    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 16px;
    }

    .search {
        max-width: 420px;
        flex: 1;
    }

    .search input {
        width: 100%;
        border-radius: 10px;
        padding: .65rem .8rem;
        border: 1px solid rgba(255, 255, 255, .12);
        background: rgba(255, 255, 255, .08);
        color: #fff
    }

    .kpis {
        display: grid;
        grid-template-columns: repeat(7, minmax(120px, 1fr));
        gap: .9rem;
        margin-bottom: 16px;
    }

    .kpi {
        background: var(--card);
        border-radius: 12px;
        padding: .9rem;
        box-shadow: var(--shadow);
        transition: transform .2s
    }

    .kpi:hover {
        transform: translateY(-4px)
    }

    .kpi .num {
        font-size: 1.25rem;
        font-weight: 800
    }

    .kpi .label {
        font-size: .72rem;
        color: #64748b
    }

    .tabs {
        display: flex;
        gap: .5rem;
        margin: 10px 0 16px
    }

    .tab {
        border: 1px solid #cbd5e1;
        padding: .4rem .7rem;
        border-radius: 999px;
        background: #fff;
        font-weight: 600;
        font-size: .8rem
    }

    .tab.active {
        background: #0ea5e9;
        color: #fff;
        border-color: #0ea5e9
    }

    .cards {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 1rem
    }

    .col-8 {
        grid-column: span 8
    }

    .col-4 {
        grid-column: span 4
    }

    .panel {
        background: var(--card);
        border-radius: 14px;
        box-shadow: var(--shadow);
        padding: 14px
    }

    /* Kanban */
    .kanban {
        display: grid;
        grid-template-columns: repeat(6, minmax(240px, 1fr));
        gap: 12px;
    }

    .lane {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        max-height: 68vh
    }

    .lane-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .6rem .75rem;
        font-weight: 700;
        border-bottom: 1px solid #e5e7eb
    }

    .lane-body {
        overflow: auto;
        padding: .6rem
    }

    .bug {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: .55rem .6rem;
        margin-bottom: .6rem;
        box-shadow: 0 6px 14px -8px rgba(0, 0, 0, .22);
        transition: transform .15s, box-shadow .15s
    }

    .bug:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -8px rgba(0, 0, 0, .28)
    }

    .chip {
        display: inline-block;
        padding: .15rem .45rem;
        border-radius: 999px;
        font-size: .65rem;
        font-weight: 700
    }

    .sev-high {
        background: #fee2e2;
        color: #b91c1c
    }

    .sev-med {
        background: #ffedd5;
        color: #c2410c
    }

    .sev-low {
        background: #dcfce7;
        color: #166534
    }

    .assignees {
        display: flex;
    }

    .avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #e2e8f0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: .7rem;
        border: 1px solid #fff;
        margin-left: -6px
    }

    .table-wrap {
        overflow: auto;
        max-height: 68vh;
        border: 1px solid #e5e7eb;
        border-radius: 12px
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0
    }

    thead {
        position: sticky;
        top: 0;
        background: #f8fafc;
        z-index: 5
    }

    th,
    td {
        padding: .6rem .5rem;
        white-space: nowrap;
        text-align: center;
        font-size: .9rem
    }

    th.tl,
    td.tl {
        text-align: left
    }

    .bulk {
        display: flex;
        gap: .4rem;
        align-items: center
    }

    /* Projects */
    .project {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: .8rem;
        box-shadow: var(--shadow);
        transition: transform .2s
    }

    .project:hover {
        transform: translateY(-3px)
    }

    .progress {
        height: 8px;
        background: #e5e7eb;
        border-radius: 999px;
        overflow: hidden
    }

    .progress>span {
        display: block;
        height: 100%;
        background: linear-gradient(90deg, var(--teal), #22d3ee)
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .kpis {
            grid-template-columns: repeat(3, 1fr)
        }

        .cards {
            grid-template-columns: 1fr
        }

        .col-8,
        .col-4 {
            grid-column: span 1
        }

        .kanban {
            grid-template-columns: repeat(3, 1fr)
        }
    }

    @media (max-width: 680px) {
        .shell {
            flex-direction: column
        }

        .sidebar {
            position: relative;
            width: 100%;
            height: auto;
            top: auto
        }

        .kpis {
            grid-template-columns: repeat(2, 1fr)
        }

        .kanban {
            grid-auto-flow: column;
            grid-auto-columns: 88%;
            overflow-x: auto;
            scroll-snap-type: x mandatory
        }

        .lane {
            scroll-snap-align: start
        }
    }
</style>
<div class="shell">
    <aside class="sidebar">
        <div class="sb-head">🐞 Admin Panel</div>
        <nav>
            <a class="sb-link active" href="#overview">Overview</a>
            <a class="sb-link" href="#projects">Projects</a>
            <a class="sb-link" href="#bugs">Bugs</a>
            <a class="sb-link" href="#users">Users</a>
            <a class="sb-link" href="#reports">Reports</a>
            <a class="sb-link" href="#settings">Settings</a>
        </nav>
    </aside>
    <main class="main">
        <div class="topbar">
            <div class="search"><input placeholder="Search bugs, users, projects..." /></div>
            <div class="tabs">
                <button class="tab active" data-view="board">Board</button>
                <button class="tab" data-view="list">List</button>
            </div>
            <div class="bulk">
                <button class="btn btn-sm btn-outline-secondary">Filters</button>
                <button class="btn btn-sm btn-outline-light">🔔</button>
                <div class="avatar" title="Admin">A</div>
            </div>
        </div>

        <section id="overview">
            <div class="kpis">
                <div class="kpi">
                    <div class="num">{{ $metrics['open'] ?? 0 }}</div>
                    <div class="label">Open Bugs</div>
                </div>
                <div class="kpi">
                    <div class="num">{{ $metrics['assigned'] ?? 0 }}</div>
                    <div class="label">Assigned</div>
                </div>
                <div class="kpi">
                    <div class="num">{{ $metrics['in_qa'] ?? 0 }}</div>
                    <div class="label">In QA</div>
                </div>
                <div class="kpi">
                    <div class="num">{{ $metrics['resolved'] ?? 0 }}</div>
                    <div class="label">Resolved</div>
                </div>
                <div class="kpi">
                    <div class="num">{{ $projects->count() ?? 0 }}</div>
                    <div class="label">Active Projects</div>
                </div>
                <div class="kpi">
                    <div class="num">{{ $developers->count() ?? 0 }}</div>
                    <div class="label">Developers</div>
                </div>
                <div class="kpi">
                    <div class="num">{{ $qas->count() ?? 0 }}</div>
                    <div class="label">QAs</div>
                </div>
            </div>
        </section>

        <div class="cards">
            <div class="col-8">
                <div class="panel" id="bugs">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="mb-0">Bugs</h5>
                        <div>
                            <button class="btn btn-sm btn-outline-secondary" data-view="board">Board</button>
                            <button class="btn btn-sm btn-outline-secondary" data-view="list">List</button>
                        </div>
                    </div>
                    <div id="view-board" class="kanban">
                        @php
                        $lanes = [
                        'Backlog' => $bugs->where('status','open'),
                        'Assigned' => $bugs->filter(fn($b)=>$b->assigned_to && !in_array($b->status,['in_progress','done','completed'])),
                        'In Progress' => $bugs->whereIn('status',['in_progress','inprogress']),
                        'QA' => $bugs->where('status','review'),
                        'Resolved' => $bugs->whereIn('status',['done','completed']),
                        'Closed' => collect(),
                        ];
                        @endphp
                        @foreach($lanes as $label => $items)
                        <div class="lane">
                            <div class="lane-head"><span>{{ $label }}</span><span class="badge bg-secondary">{{ $items->count() }}</span></div>
                            <div class="lane-body">
                                @forelse($items as $bug)
                                <div class="bug" draggable="true">
                                    <div class="d-flex justify-content-between">
                                        <strong>#{{ $bug->id }}</strong>
                                        <span class="chip {{ $bug->severity==='high' ? 'sev-high' : ($bug->severity==='medium'?'sev-med':'sev-low') }}">{{ ucfirst($bug->severity ?? 'low') }}</span>
                                    </div>
                                    <div class="tl">{{ $bug->title }}</div>
                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                        <small class="text-muted">{{ optional($bug->project)->name ?? '—' }}</small>
                                        <div class="assignees">
                                            @if(optional($bug->assignedTo)->name)
                                            <div class="avatar" title="{{ $bug->assignedTo->name }}">{{ strtoupper(substr($bug->assignedTo->name,0,1)) }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('admin.bugs.assign', $bug) }}" class="mt-2 d-flex gap-1">
                                        @csrf
                                        <select name="developer_id" class="form-select form-select-sm" style="max-width: 160px">
                                            <option value="">Assign Dev</option>
                                            @foreach($developers as $dev)
                                            <option value="{{ $dev->id }}" @if($bug->assigned_to==$dev->id) selected @endif>{{ $dev->name }}</option>
                                            @endforeach
                                        </select>
                                        <select name="qa_id" class="form-select form-select-sm" style="max-width: 160px">
                                            <option value="">Assign QA</option>
                                            @foreach($qas as $qa)
                                            <option value="{{ $qa->id }}" @if($bug->reviewed_by==$qa->id) selected @endif>{{ $qa->name }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-sm btn-outline-primary">Assign</button>
                                    </form>
                                </div>
                                @empty
                                <div class="text-muted small">No items</div>
                                @endforelse
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="view-list" class="mt-2" style="display:none">
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" /></th>
                                        <th>Bug ID</th>
                                        <th class="tl">Title</th>
                                        <th>Severity</th>
                                        <th>Status</th>
                                        <th>Project</th>
                                        <th>Assignees</th>
                                        <th>Reported By</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bugs as $b)
                                    <tr>
                                        <td><input type="checkbox" /></td>
                                        <td>#{{ $b->id }}</td>
                                        <td class="tl">{{ $b->title }}</td>
                                        <td>{{ ucfirst($b->severity ?? 'low') }}</td>
                                        <td>{{ str_replace('_',' ', $b->status) }}</td>
                                        <td>{{ optional($b->project)->name ?? '—' }}</td>
                                        <td>{{ optional($b->assignedTo)->name ?? '—' }}</td>
                                        <td>{{ optional($b->creator)->name ?? '—' }}</td>
                                        <td>{{ $b->created_at?->format('Y-m-d') }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.bugs.assign', $b) }}" class="d-flex gap-1">
                                                @csrf
                                                <select name="developer_id" class="form-select form-select-sm" style="max-width: 140px">
                                                    <option value="">Assign Dev</option>
                                                    @foreach($developers as $dev)
                                                    <option value="{{ $dev->id }}" @if($b->assigned_to==$dev->id) selected @endif>{{ $dev->name }}</option>
                                                    @endforeach
                                                </select>
                                                <select name="qa_id" class="form-select form-select-sm" style="max-width: 140px">
                                                    <option value="">Assign QA</option>
                                                    @foreach($qas as $qa)
                                                    <option value="{{ $qa->id }}" @if($b->reviewed_by==$qa->id) selected @endif>{{ $qa->name }}</option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-sm btn-outline-primary">✔️</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="panel" id="projects">
                    <h5 class="mb-2">Projects</h5>
                    <div class="d-grid" style="grid-template-columns: 1fr; gap:.7rem">
                        @forelse($projects as $p)
                        <div class="project">
                            <div class="d-flex justify-content-between"><strong>{{ $p->name }}</strong><span class="badge text-bg-info">{{ $p->open_bugs ?? 0 }} bugs</span></div>
                            <div class="progress mt-2"><span data-progress="{{ (int)($p->progress ?? 35) }}"></span></div>
                            <div class="d-flex justify-content-between mt-2 align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar" title="PM">{{ strtoupper(substr(optional($p->pm)->name ?? 'P',0,1)) }}</div>
                                    <small class="text-muted">PM</small>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary">Open Project</a>
                            </div>
                        </div>
                        @empty
                        <div class="text-muted small">No projects</div>
                        @endforelse
                    </div>
                </div>
                <div class="panel mt-3" id="users">
                    <h5 class="mb-2">Team</h5>
                    <div class="d-grid" style="grid-template-columns: 1fr; gap:.6rem">
                        @foreach($developers as $u)
                        <div class="d-flex justify-content-between align-items-center p-2 border rounded-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar">{{ strtoupper(substr($u->name,0,1)) }}</div>
                                <div>
                                    <div class="fw-bold">{{ $u->name }}</div>
                                    <small class="text-muted">Developer</small>
                                </div>
                            </div>
                            <div class="d-flex gap-1">
                                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete user {{ $u->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                        <hr />
                        <h6 class="mt-1">QA</h6>
                        @foreach($qas as $u)
                        <div class="d-flex justify-content-between align-items-center p-2 border rounded-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar">{{ strtoupper(substr($u->name,0,1)) }}</div>
                                <div>
                                    <div class="fw-bold">{{ $u->name }}</div>
                                    <small class="text-muted">QA</small>
                                </div>
                            </div>
                            <div class="d-flex gap-1">
                                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete user {{ $u->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                        <hr />
                        <h6 class="mt-1">Project Managers</h6>
                        @foreach($pms as $u)
                        <div class="d-flex justify-content-between align-items-center p-2 border rounded-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar">{{ strtoupper(substr($u->name,0,1)) }}</div>
                                <div>
                                    <div class="fw-bold">{{ $u->name }}</div>
                                    <small class="text-muted">PM</small>
                                </div>
                            </div>
                            <div class="d-flex gap-1">
                                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete user {{ $u->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                        <hr />
                        <h6 class="mt-2">Add User</h6>
                        <form method="POST" action="{{ route('admin.users.store') }}" class="d-grid" style="grid-template-columns: 1fr; gap:.4rem">
                            @csrf
                            <input name="name" class="form-control form-control-sm" placeholder="Full name" required />
                            <input type="email" name="email" class="form-control form-control-sm" placeholder="Email" required />
                            <input type="password" name="password" class="form-control form-control-sm" placeholder="Password" required />
                            <select name="role" class="form-select form-select-sm" required>
                                <option value="QA">QA</option>
                                <option value="Dev">Developer</option>
                                <option value="PM">Project Manager</option>
                            </select>
                            <button class="btn btn-sm btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.tab');
        const board = document.getElementById('view-board');
        const list = document.getElementById('view-list');
        tabs.forEach(t => t.addEventListener('click', () => {
            tabs.forEach(x => x.classList.remove('active'));
            t.classList.add('active');
            const v = t.dataset.view;
            board.style.display = v === 'board' ? '' : 'none';
            list.style.display = v === 'list' ? '' : 'none';
        }));
        document.querySelectorAll('.progress > span[data-progress]').forEach(el => {
            const v = Math.max(0, Math.min(100, parseInt(el.dataset.progress || '0', 10)));
            el.style.width = v + '%';
        });
    });
</script>
@endsection