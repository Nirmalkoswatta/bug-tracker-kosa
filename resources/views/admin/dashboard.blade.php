@extends('layouts.app')
@section('content')
@php
$bugsCollection = isset($bugs) ? $bugs : (isset($bugsSample) ? $bugsSample : collect());
@endphp

<div class="container-fluid px-3 px-md-4 mt-3">
    <style>
        .admin-shell-wrapper {
            min-height: calc(100vh - 120px);
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }

        .admin-glass-panel {
            width: 100%;
            max-width: 1450px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px) saturate(140%);
            -webkit-backdrop-filter: blur(12px) saturate(140%);
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 28px;
            padding: 2.2rem 2.1rem 2rem;
            position: relative;
            box-shadow: 0 10px 32px -6px rgba(0, 0, 0, 0.55);
        }

        .admin-glass-panel h2 {
            font-weight: 600;
            letter-spacing: .5px;
            color: #fff !important;
        }

        .admin-section-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #ffffff55, transparent);
            margin: .85rem 0 1.4rem;
        }

        @media (max-width: 991.98px) {
            .admin-glass-panel {
                padding: 1.75rem 1.4rem 1.4rem;
                border-radius: 22px;
            }
        }

        @media (max-width: 575.98px) {
            .admin-glass-panel {
                padding: 1.4rem 1.05rem 1.1rem;
                border-radius: 18px;
            }
        }
    </style>
    <div class="admin-shell-wrapper">
        <div class="admin-glass-panel">
            <h2 class="mb-2">Admin Dashboard</h2>
            <p class="mb-2" style="font-size:.9rem; color:#fff;">Admin can manage all bugs, users, and permissions here.</p>
            <div class="admin-section-divider"></div>

            {{-- Background wrapper with image (full height) --}}
            <style>
                .dashboard-bg {
                    background:url("{{ asset('10780356_19199649.jpg') }}") no-repeat center center fixed;
                    background-size: cover;
                    border-radius: 10px;
                    position: relative;
                }

                .dashboard-overlay {
                    background: rgba(255, 255, 255, 0.15);
                    backdrop-filter: blur(10px) saturate(140%);
                    -webkit-backdrop-filter: blur(10px) saturate(140%);
                    border: 1px solid rgba(255, 255, 255, 0.35);
                    border-radius: 10px;
                    box-shadow: 0 4px 18px -2px rgba(0, 0, 0, 0.4);
                }

                .transparent-table {
                    --tbl-border: rgba(255, 255, 255, 0.35);
                    --tbl-row: rgba(255, 255, 255, 0.10);
                    --tbl-row-alt: rgba(255, 255, 255, 0.05);
                    --tbl-hover: rgba(255, 255, 255, 0.18);
                    color: #fff;
                }

                .transparent-table thead {
                    background: rgba(0, 0, 0, 0.55) !important;
                    color: #f1f1f1;
                }

                .transparent-table tbody tr {
                    background: var(--tbl-row);
                }

                .transparent-table tbody tr:nth-child(even) {
                    background: var(--tbl-row-alt);
                }

                .transparent-table tbody tr:hover {
                    background: var(--tbl-hover);
                }

                .transparent-table td,
                .transparent-table th {
                    border: 1px solid var(--tbl-border) !important;
                }

                .badge.bg-warning.text-dark {
                    color: #222 !important;
                }
            </style>
            <div class="mt-2 p-3 dashboard-bg" style="border-radius:18px;">
                <div class="dashboard-overlay p-3" style="border-radius:16px;">
                    @if($bugsCollection->count())
                    <h4 class="mt-2">All Bugs <span class="badge bg-secondary">{{ $bugsCollection->count() }}</span></h4>
                    <div class="table-responsive mb-4">
                        <table class="table table-sm table-bordered align-middle mb-0 transparent-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>QA (Creator)</th>
                                    <th>Assigned Dev</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bugsCollection as $bug)
                                @php
                                $id = is_array($bug) ? ($bug['id'] ?? '') : ($bug->id ?? '');
                                $title = is_array($bug) ? ($bug['title'] ?? '') : ($bug->title ?? '');
                                $status = strtolower(is_array($bug) ? ($bug['status'] ?? '') : ($bug->status ?? ''));
                                $creator = is_array($bug) ? ($bug['creator'] ?? ($bug['qa_creator'] ?? '')) : ($bug->creator ?? $bug->qa_creator ?? '');
                                $assigned = is_array($bug) ? ($bug['assigned'] ?? ($bug['assigned_dev'] ?? '')) : ($bug->assigned ?? $bug->assigned_dev ?? '');
                                $badgeClass = match($status){
                                'open' => 'bg-danger',
                                'in progress','in_progress' => 'bg-warning text-dark',
                                'done' => 'bg-success',
                                default => 'bg-secondary'
                                };
                                @endphp
                                @php
                                // Pre-encode JSON payload safely to avoid Blade parse issues with @json inside attributes
                                $bugPayload = htmlspecialchars(json_encode([
                                'id' => $id,
                                'title' => $title,
                                'status' => $status,
                                'creator' => $creator,
                                'assigned' => $assigned,
                                ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES), ENT_QUOTES, 'UTF-8');
                                @endphp
                                <tr>
                                    <td>{{ $id }}</td>
                                    <td>{{ $title }}</td>
                                    <td><span class="badge {{ $badgeClass }}">{{ ucfirst($status) }}</span></td>
                                    <td>{{ $creator }}</td>
                                    <td>{{ $assigned }}</td>
                                    <td class="d-flex gap-2 flex-wrap">
                                        <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#bugViewModal" data-bug="{{ $bugPayload }}">View</button>
                                        @if(Route::has('bugs.destroy'))
                                        <form action="{{ route('bugs.destroy',$id) }}" method="POST" onsubmit="return confirm('Delete bug #{{ $id }}?');" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-light py-2 mb-4 border">No bugs available.</div>
                    @endif

                    <h4 class="mt-4 text-white">Developers <span class="badge bg-secondary">{{ isset($developers)? $developers->count():0 }}</span></h4>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-sm align-middle mb-0 transparent-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Can Access QAs</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($developers as $dev)
                                <tr>
                                    <td>{{ $dev->name }}</td>
                                    <td>{{ $dev->email }}</td>
                                    <td>
                                        @if($dev->can_access_qas)
                                        <span class="badge bg-success">Yes</span>
                                        @else
                                        <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(Route::has('admin.toggleQAs'))
                                        <form method="POST" action="{{ route('admin.toggleQAs', $dev->id) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">{{ $dev->can_access_qas ? 'Revoke' : 'Allow' }}</button>
                                        </form>
                                        @endif
                                        @if(Route::has('admin.users.destroy'))
                                        <form method="POST" action="{{ route('admin.users.destroy', $dev->id) }}" class="d-inline" onsubmit="return confirm('Delete developer {{ $dev->name }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No developers found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h4 class="text-white">QAs <span class="badge bg-secondary">{{ isset($qas)? $qas->count():0 }}</span></h4>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-sm align-middle mb-0 transparent-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($qas as $qa)
                                <tr>
                                    <td>{{ $qa->name }}</td>
                                    <td>{{ $qa->email }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">No QA users found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h4 class="text-white">Project Managers <span class="badge bg-secondary">{{ isset($pms)? $pms->count():0 }}</span></h4>
                    <div class="table-responsive mb-2">
                        <table class="table table-bordered table-sm align-middle mb-0 transparent-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pms as $pm)
                                <tr>
                                    <td>{{ $pm->name }}</td>
                                    <td>{{ $pm->email }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">No project managers found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- /.admin-glass-panel -->
    </div><!-- /.admin-shell-wrapper -->
</div>

<!-- View Modal (Bootstrap) -->
<div class="modal fade" id="bugViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bug Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body small" id="bug-view-body">
                <div class="text-muted">Select a bug to view details.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalEl = document.getElementById('bugViewModal');
        if (!modalEl) return;
        modalEl.addEventListener('show.bs.modal', function(ev) {
            const btn = ev.relatedTarget;
            if (!btn) return;
            const data = btn.getAttribute('data-bug');
            let obj = {};
            try {
                obj = JSON.parse(data);
            } catch (e) {}
            const html = `
      <table class="table table-sm table-bordered mb-0">
        <tbody>
          <tr><th style="width:120px">ID</th><td>${(obj.id??'')}</td></tr>
          <tr><th>Title</th><td>${(obj.title??'').toString().replace(/</g,'&lt;')}</td></tr>
            <tr><th>Status</th><td><span class="badge bg-secondary">${(obj.status??'').toString().replace(/</g,'&lt;')}</span></td></tr>
          <tr><th>Creator</th><td>${(obj.creator??'').toString().replace(/</g,'&lt;')}</td></tr>
          <tr><th>Assigned</th><td>${(obj.assigned??'').toString().replace(/</g,'&lt;')}</td></tr>
        </tbody>
      </table>`;
            document.getElementById('bug-view-body').innerHTML = html;
        });
    });
</script>
@endsection