@extends('layouts.clean')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Dashboard</h2>
    <p class="text-slate-500 text-sm">Your work at a glance. Use filters to focus on what matters.</p>
    <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
            <div class="text-xs font-semibold text-slate-500">Open</div>
            <div class="text-2xl font-black text-slate-800">{{ $metrics['open'] ?? 0 }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
            <div class="text-xs font-semibold text-slate-500">Assigned</div>
            <div class="text-2xl font-black text-slate-800">{{ $metrics['assigned'] ?? 0 }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
            <div class="text-xs font-semibold text-slate-500">In QA</div>
            <div class="text-2xl font-black text-slate-800">{{ $metrics['in_qa'] ?? 0 }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
            <div class="text-xs font-semibold text-slate-500">Resolved</div>
            <div class="text-2xl font-black text-slate-800">{{ $metrics['resolved'] ?? 0 }}</div>
        </div>
    </div>
</div>

<!-- Filters -->
<form method="GET" action="{{ route('dashboard') }}" class="mb-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
    <div>
        <label class="block text-xs font-semibold text-slate-600 mb-1">Search</label>
        <input type="search" name="q" value="{{ $q ?? '' }}" placeholder="Title contains…" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
    </div>
    <div>
        <label class="block text-xs font-semibold text-slate-600 mb-1">Status</label>
        <select name="status" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Any</option>
            @php $statuses = ['open' => 'Open', 'in_progress' => 'In Progress', 'review' => 'In QA', 'done' => 'Done']; @endphp
            @foreach($statuses as $val=>$label)
            <option value="{{ $val }}" @selected(($status ?? null)===$val)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs font-semibold text-slate-600 mb-1">Severity</label>
        <select name="severity" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Any</option>
            @foreach(['low','medium','high'] as $sev)
            <option value="{{ $sev }}" @selected(($severity ?? null)===$sev)>{{ ucfirst($sev) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs font-semibold text-slate-600 mb-1">Project</label>
        <select name="project_id" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All projects</option>
            @foreach(($allProjects ?? []) as $p)
            <option value="{{ $p->id }}" @selected(($projectId ?? null)==$p->id)>{{ $p->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex items-end gap-2">
        <button class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
            <i class="fa fa-filter"></i> Apply
        </button>
        <a href="{{ route('dashboard') }}" class="text-sm text-slate-600 hover:text-slate-800">Reset</a>
    </div>
</form>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <!-- Issues table -->
    <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm">
        <div class="p-4 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-800">Issues</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Title</th>
                        <th class="px-4 py-2">Severity</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Project</th>
                        <th class="px-4 py-2">Assignee</th>
                        <th class="px-4 py-2">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($bugs as $b)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-2 font-semibold text-slate-700">#{{ $b->id }}</td>
                        <td class="px-4 py-2 text-slate-800">{{ $b->title }}</td>
                        <td class="px-4 py-2">
                            @php
                            $sev = strtolower($b->severity ?? 'low');
                            $sevMap = [
                            'high' => 'bg-rose-100 text-rose-700',
                            'medium' => 'bg-amber-100 text-amber-700',
                            'low' => 'bg-emerald-100 text-emerald-700',
                            ];
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ $sevMap[$sev] ?? 'bg-slate-100 text-slate-700' }}">{{ ucfirst($sev) }}</span>
                        </td>
                        <td class="px-4 py-2">{{ str_replace('_',' ', $b->status) }}</td>
                        <td class="px-4 py-2">{{ optional($b->project)->name ?? '—' }}</td>
                        <td class="px-4 py-2">{{ optional($b->assignedTo)->name ?? '—' }}</td>
                        <td class="px-4 py-2">{{ $b->created_at?->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3 border-t border-slate-200">
            {{ $bugs->links() }}
        </div>
    </div>

    <!-- Projects grid -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm">
        <div class="p-4 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-800">Projects</h3>
        </div>
        <div class="p-4 grid grid-cols-1 gap-3">
            @forelse($projects as $proj)
            <div class="border border-slate-200 rounded-lg p-3 hover:shadow-sm transition">
                <div class="font-semibold text-slate-800">{{ $proj->name }}</div>
                <div class="text-sm text-slate-600 mt-1">{{ Str::limit($proj->description, 100) ?: '—' }}</div>
                <div class="text-xs text-slate-500 mt-2">Created: {{ optional($proj->created_at)->format('d M Y') }}</div>
            </div>
            @empty
            <div class="text-slate-500 text-sm">No recent projects.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection