@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Bugs</h4>
    <div class="btn-group">
        <a href="{{ route('admin.bugs',[],false) }}" class="btn btn-sm btn-outline-secondary">List</a>
        <a href="{{ route('admin.bugs',[],false) }}#board" class="btn btn-sm btn-outline-secondary">Board</a>
    </div>
</div>
<div class="ui-card" id="board">
    <div class="fw-bold mb-2">Board</div>
    <div class="kanban" style="display:grid;grid-template-columns:repeat(6,minmax(220px,1fr));gap:12px">
        @php
        $lanes = [
        'Backlog' => $bugs->where('status','open'),
        'Assigned' => $bugs->filter(fn($b)=>$b->assigned_to && !in_array($b->status,['in_progress','done','completed'])),
        'In Progress' => $bugs->whereIn('status',["in_progress","inprogress"]),
        'QA' => $bugs->where('status','review'),
        'Resolved' => $bugs->whereIn('status',['done','completed']),
        'Closed' => collect(),
        ];
        @endphp
        @foreach($lanes as $label=>$items)
        <div class="lane" style="background:#f8fafc;border:1px solid #e5e7eb;border-radius:12px;display:flex;flex-direction:column">
            <div class="lane-head d-flex justify-content-between align-items-center p-2 fw-bold">{{ $label }} <span class="badge bg-secondary">{{ $items->count() }}</span></div>
            <div class="lane-body p-2" style="max-height:65vh;overflow:auto">
                @forelse($items as $bug)
                <div class="bug" style="background:#fff;border:1px solid #e5e7eb;border-radius:10px;padding:.5rem .6rem;margin-bottom:.6rem;box-shadow:0 6px 14px -8px rgba(0,0,0,.18)">
                    <div class="d-flex justify-content-between small"><strong>#{{ $bug->id }}</strong><span>{{ ucfirst($bug->severity ?? 'low') }}</span></div>
                    <div class="tl">{{ $bug->title }}</div>
                    <form method="POST" action="{{ route('admin.bugs.assign',$bug) }}" class="mt-2 d-flex gap-1">
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
                    <td>
                        <form method="POST" action="{{ route('admin.bugs.assign',$b) }}" class="d-inline-flex gap-1">
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
                            <button class="btn btn-sm btn-outline-primary">✔️</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection