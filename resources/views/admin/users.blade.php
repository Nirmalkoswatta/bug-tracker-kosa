@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Users</h4>
    <form method="POST" action="{{ route('admin.users.store') }}" class="d-flex gap-2">
        @csrf
        <input name="name" class="form-control form-control-sm" placeholder="Full name" required>
        <input name="email" type="email" class="form-control form-control-sm" placeholder="Email" required>
        <input name="password" type="password" class="form-control form-control-sm" placeholder="Password" required>
        <select name="role" class="form-select form-select-sm" required>
            <option value="QA">QA</option>
            <option value="Dev">Developer</option>
            <option value="PM">Project Manager</option>
        </select>
        <button class="btn btn-sm btn-primary">Add</button>
    </form>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="ui-card">
            <h6>Developers ({{ $developers->count() }})</h6>
            @forelse($developers as $u)
            <div class="d-flex justify-content-between align-items-center p-2 border rounded-3 mb-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar">{{ strtoupper(substr($u->name,0,1)) }}</div>
                    <div>
                        <div class="fw-bold">{{ $u->name }}</div><small class="text-muted">{{ $u->email }}</small>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete user {{ $u->name }}?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </div>
            @empty
            <div class="text-muted small">No developers.</div>
            @endforelse
        </div>
    </div>
    <div class="col-lg-4">
        <div class="ui-card">
            <h6>QAs ({{ $qas->count() }})</h6>
            @forelse($qas as $u)
            <div class="d-flex justify-content-between align-items-center p-2 border rounded-3 mb-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar">{{ strtoupper(substr($u->name,0,1)) }}</div>
                    <div>
                        <div class="fw-bold">{{ $u->name }}</div><small class="text-muted">{{ $u->email }}</small>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete user {{ $u->name }}?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </div>
            @empty
            <div class="text-muted small">No QAs.</div>
            @endforelse
        </div>
    </div>
    <div class="col-lg-4">
        <div class="ui-card">
            <h6>Project Managers ({{ $pms->count() }})</h6>
            @forelse($pms as $u)
            <div class="d-flex justify-content-between align-items-center p-2 border rounded-3 mb-2">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar">{{ strtoupper(substr($u->name,0,1)) }}</div>
                    <div>
                        <div class="fw-bold">{{ $u->name }}</div><small class="text-muted">{{ $u->email }}</small>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete user {{ $u->name }}?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </div>
            @empty
            <div class="text-muted small">No PMs.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection