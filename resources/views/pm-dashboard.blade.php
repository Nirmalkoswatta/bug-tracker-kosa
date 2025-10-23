@extends('layouts.app')

@section('content')
<div class="container" style='margin-top: 90px; max-width: 1200px; min-width: 320px; width: 100%; background-image: url("{{ asset('10780356_19199649.jpg') }}"); background-repeat: no-repeat; background-position: center center; background-attachment: fixed; background-size: cover; min-height: 100vh;'>
    <style>
        .pm-glass-table {
            --bdr: rgba(255, 255, 255, 0.35);
            --row: rgba(255, 255, 255, 0.10);
            --row-alt: rgba(255, 255, 255, 0.05);
            --hover: rgba(255, 255, 255, 0.18);
            color: #fff;
        }

        .pm-glass-table thead {
            background: rgba(0, 0, 0, 0.55) !important;
            color: #f1f1f1;
        }

        .pm-glass-table tbody tr {
            background: var(--row);
        }

        .pm-glass-table tbody tr:nth-child(even) {
            background: var(--row-alt);
        }

        .pm-glass-table tbody tr:hover {
            background: var(--hover);
        }

        .pm-glass-table td,
        .pm-glass-table th {
            border: 1px solid var(--bdr) !important;
        }

        .sev-badge {
            font-weight: 700;
            border-radius: 999px;
            padding: .2rem .6rem;
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

        h2.pm-title {
            color: #fff;
            font-weight: 600;
            letter-spacing: .5px;
        }
    </style>
    <h2 class="pm-title mb-3">Project Manager Dashboard</h2>
    <table class="table table-bordered pm-glass-table align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Severity</th>
                <th>Assigned To</th>
                <th>Created By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bugs as $bug)
            <tr>
                <td>{{ $bug->id }}</td>
                <td>{{ $bug->title }}</td>
                <td>{{ $bug->status }}</td>
                <td>
                    @php $sev = strtolower($bug->severity ?? 'low'); @endphp
                    <span class="sev-badge {{ 'sev-' . $sev }}">{{ ucfirst($sev) }}</span>
                </td>
                <td>{{ optional($bug->assignedTo)->name }}</td>
                <td>{{ optional($bug->creator)->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection