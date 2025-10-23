@extends('layouts.admin')
@section('admin-content')
<div class="max-w-full">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Issues</h2>
            <p class="text-slate-500 text-sm">A place where you can manage issues added by yourself…</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Issue</th>
                        <th class="px-4 py-3">Classification</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Severity</th>
                        <th class="px-4 py-3">Project</th>
                        <th class="px-4 py-3">Assignee</th>
                        <th class="px-4 py-3">Creation Date</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bugs as $b)
                    @php
                    $severity = strtolower($b->severity ?? 'low');
                    $sevClass = match($severity){
                    'critical' => 'bg-red-500/10 text-red-600',
                    'high' => 'bg-orange-500/10 text-orange-600',
                    'medium' => 'bg-yellow-500/10 text-yellow-700',
                    default => 'bg-green-500/10 text-green-600',
                    };
                    @endphp
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="font-medium text-slate-800">#{{ $b->id }} — {{ $b->title }}</div>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ $b->classification ?? '-' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ ucfirst(str_replace('_',' ', $b->status)) }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $sevClass }}">{{ ucfirst($severity) }}</span>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ optional($b->project)->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ optional($b->assignedTo)->name ?? 'Not assigned' }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ optional($b->created_at)->format('d F Y') }}</td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('bugs.edit', $b->id) }}" class="text-slate-500 hover:text-blue-600 mr-3" title="Edit"><i class="fa fa-pen"></i></a>
                            <form action="{{ route('bugs.destroy', $b->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this issue?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-slate-500 hover:text-red-600" title="Delete"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-slate-500">No issues found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-slate-200">
            {{ method_exists($bugs, 'links') ? $bugs->links() : '' }}
        </div>
    </div>
</div>
@endsection