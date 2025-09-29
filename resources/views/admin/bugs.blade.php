@extends('layouts.admin')
@php($section='bugs')
@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Bugs</h4>
    <div class="d-flex gap-2">
        <div class="btn-group">
            <a href="{{ route('admin.bugs',[],false) }}" class="btn btn-sm btn-outline-secondary">List</a>
            <a href="{{ route('admin.bugs',[],false) }}#board" class="btn btn-sm btn-outline-secondary">Board</a>
        </div>
        <a href="{{ route('bugs.create') }}" class="btn btn-sm btn-primary">Create Bug</a>
    </div>
</div>
<div class="ui-card" id="board">
    <style>
        /* Scoped board layout adjustments to prevent clipping under navbar */
        .kanban {
            display: grid;
            grid-template-columns: repeat(6, minmax(220px, 1fr));
            gap: 12px;
        }

        .lane-body {
            /* dynamic height excluding nav + surrounding chrome */
            max-height: calc(100vh - var(--nav-h, 88px) - 190px);
            overflow: auto;
        }

        @media (max-width:1400px) {
            .kanban {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            }
        }

        @media (max-width:900px) {
            .kanban {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }
    </style>
    <div class="fw-bold mb-2">Board</div>
    <div class="kanban">
        @php
        if(!isset($lanes)) {
        $collection = ($bugs instanceof \Illuminate\Support\Collection) ? $bugs : collect($bugs ?? []);
        $lanes = [
        'Backlog' => $collection->where('status','open'),
        'Assigned' => $collection->filter(fn($b)=>$b->assigned_to && !in_array($b->status,['in_progress','inprogress','done','completed'])),
        'In Progress' => $collection->filter(fn($b)=>in_array($b->status,['in_progress','inprogress'])),
        'QA' => $collection->where('status','review'),
        'Resolved' => $collection->filter(fn($b)=>in_array($b->status,['done','completed'])),
        'Closed' => collect(),
        ];
        }
        @endphp
        @foreach($lanes as $label=>$items)
        <div class="lane" style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:12px;display:flex;flex-direction:column">
            <div class="lane-head d-flex justify-content-between align-items-center p-2 fw-bold">{{ $label }} <span class="badge bg-secondary">{{ $items->count() }}</span></div>
            <div class="lane-body p-2">
                @forelse($items as $bug)
                <div class="bug" style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:.5rem .6rem;margin-bottom:.6rem;box-shadow:0 6px 14px -8px rgba(0,0,0,.18)" aria-label="Bug #{{ $bug->id }}">
                    <div class="d-flex justify-content-between small"><strong>#{{ $bug->id }}</strong><span class="visually-hidden">Severity {{ ucfirst($bug->severity ?? 'low') }}</span></div>
                    <div class="tl">{{ $bug->title }}</div>
                    <form method="POST" action="{{ route('admin.bugs.assign',$bug) }}" class="mt-2 d-flex flex-wrap gap-1">
                        @csrf
                        <select name="developer_id" class="form-select form-select-sm" style="max-width:140px">
                            <option value="">Assign Dev</option>
                            @foreach($developers as $dev)
                            <option value="{{ $dev->id }}" @if($bug->assigned_to==$dev->id) selected @endif>{{ $dev->name }}</option>
                            @endforeach
                        </select>
                        <select name="qa_id" class="form-select form-select-sm" style="max-width:140px">
                            <option value="">Assign QA</option>
                            @foreach($qas as $qa)
                            <option value="{{ $qa->id }}" @if($bug->reviewed_by==$qa->id) selected @endif>{{ $qa->name }}</option>
                            @endforeach
                        </select>
                        <select name="pm_id" class="form-select form-select-sm" style="max-width:140px">
                            <option value="">Assign PM</option>
                            @foreach(($pms ?? collect()) as $pm)
                            <option value="{{ $pm->id }}" @if(($bug->pm_id ?? null)==$pm->id) selected @endif>{{ $pm->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-outline-primary" aria-label="Assign users to bug {{ $bug->id }}">Assign</button>
                        <a href="{{ route('bugs.edit',$bug) }}" class="btn btn-sm btn-outline-secondary" aria-label="Edit bug {{ $bug->id }}">Edit</a>
                        <form method="POST" action="{{ route('bugs.destroy',$bug) }}" onsubmit="return confirm('Delete bug #{{ $bug->id }}?');" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" aria-label="Delete bug {{ $bug->id }}">Del</button>
                        </form>
                    </form>
                </div>
                @empty
                <div class="text-muted small">No items</div>
                @endforelse
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="ui-card mt-3">
    <div class="fw-bold mb-2">List</div>
    <div class="table-responsive">
        <table class="table table-sm align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th class="tl">Title</th>
                    <th>Status</th>
                    <th>Dev</th>
                    <th>QA</th>
                    <th>PM</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bugs as $b)
                <tr>
                    <td>#{{ $b->id }}</td>
                    <td class="tl">{{ $b->title }}</td>
                    <td>{{ $b->status }}</td>
                    <td>{{ optional($b->assignedTo)->name ?? '—' }}</td>
                    <td>{{ optional($b->reviewedBy)->name ?? '—' }}</td>
                    <td>{{ optional($pms->firstWhere('id',$b->pm_id))->name ?? '—' }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.bugs.assign',$b) }}" class="d-inline-flex flex-wrap gap-1 align-items-start">
                            @csrf
                            <select name="developer_id" class="form-select form-select-sm" style="max-width:140px">
                                <option value="">Assign Dev</option>
                                @foreach($developers as $dev)
                                <option value="{{ $dev->id }}" @if($b->assigned_to==$dev->id) selected @endif>{{ $dev->name }}</option>
                                @endforeach
                            </select>
                            <select name="qa_id" class="form-select form-select-sm" style="max-width:140px">
                                <option value="">Assign QA</option>
                                @foreach($qas as $qa)
                                <option value="{{ $qa->id }}" @if($b->reviewed_by==$qa->id) selected @endif>{{ $qa->name }}</option>
                                @endforeach
                            </select>
                            <select name="pm_id" class="form-select form-select-sm" style="max-width:140px">
                                <option value="">Assign PM</option>
                                @foreach(($pms ?? collect()) as $pm)
                                <option value="{{ $pm->id }}" @if(($b->pm_id ?? null)==$pm->id) selected @endif>{{ $pm->name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-outline-primary" aria-label="Assign users to bug {{ $b->id }}">✔️</button>
                            <a href="{{ route('bugs.edit',$b) }}" class="btn btn-sm btn-outline-secondary" aria-label="Edit bug {{ $b->id }}">Edit</a>
                            <form method="POST" action="{{ route('bugs.destroy',$b) }}" onsubmit="return confirm('Delete bug #{{ $b->id }}?');" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" aria-label="Delete bug {{ $b->id }}">Del</button>
                            </form>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection