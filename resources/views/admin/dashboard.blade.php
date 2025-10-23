@extends('layouts.clean')
@section('content')
<div class="mb-6">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Admin Dashboard</h2>
            <p class="text-slate-500 text-sm">Key metrics and your latest issues. No sidebar, focused workflow.</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg text-sm">
                <i class="fa fa-right-from-bracket"></i>
                Logout
            </button>
        </form>
    </div>
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

<div class="bg-white border border-slate-200 rounded-xl shadow-sm">
    <div class="p-4 border-b border-slate-200 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-slate-800">Latest Issues</h3>
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
                    <th class="px-4 py-2">Reporter</th>
                    <th class="px-4 py-2">Created</th>
                    <th class="px-4 py-2">Assign</th>
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
                    <td class="px-4 py-2">{{ optional($b->creator)->name ?? '—' }}</td>
                    <td class="px-4 py-2">{{ $b->created_at?->format('Y-m-d') }}</td>
                    <td class="px-4 py-2">
                        <form method="POST" action="{{ route('admin.bugs.assign', $b) }}" class="flex items-center gap-2">
                            @csrf
                            <select name="developer_id" class="bg-white border border-slate-200 rounded-md px-2 py-1 text-xs">
                                <option value="">Dev: None</option>
                                @foreach($developers as $dev)
                                <option value="{{ $dev->id }}" @if($b->assigned_to==$dev->id) selected @endif>{{ $dev->name }}</option>
                                @endforeach
                            </select>
                            <select name="qa_id" class="bg-white border border-slate-200 rounded-md px-2 py-1 text-xs">
                                <option value="">QA: None</option>
                                @foreach($qas as $qa)
                                <option value="{{ $qa->id }}" @if(($b->reviewed_by ?? null)==$qa->id) selected @endif>{{ $qa->name }}</option>
                                @endforeach
                            </select>
                            <button class="inline-flex items-center gap-1 bg-slate-800 hover:bg-slate-900 text-white px-2 py-1 rounded-md text-xs">Update</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Quick Create User -->
<div class="bg-white border border-slate-200 rounded-xl shadow-sm mt-4">
    <div class="p-4 border-b border-slate-200 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-slate-800">Quick Create Team Member</h3>
    </div>
    <div class="p-4">
        <form method="POST" action="{{ route('admin.users.store') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-2">
            @csrf
            <input name="name" class="bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm" placeholder="Full name" required>
            <input name="email" type="email" class="bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm" placeholder="Email" required>
            <input name="password" type="password" class="bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm" placeholder="Password" required>
            <select name="role" class="bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm" required>
                <option value="QA">QA</option>
                <option value="Dev">Developer</option>
                <option value="PM">Project Manager</option>
            </select>
            <button class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">Create</button>
        </form>
    </div>
</div>
@endsection