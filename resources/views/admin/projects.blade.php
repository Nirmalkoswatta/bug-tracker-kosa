@extends('layouts.clean')
@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Projects</h2>
    <p class="text-slate-500 text-sm">Your projects at a glance.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @forelse($projects as $p)
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5 transition hover:shadow-md">
        <div class="flex items-start justify-between">
            <h3 class="text-lg font-semibold text-slate-800">{{ $p->name }}</h3>
            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-700">{{ $p->bugs_count }} issues</span>
        </div>
        <p class="mt-2 text-slate-600 text-sm">{{ Str::limit($p->description, 120) ?: '—' }}</p>
        <div class="mt-4 flex items-center justify-between text-sm text-slate-500">
            <span>Open: <span class="font-semibold text-orange-600">{{ $p->open_bugs_count }}</span></span>
            <span>Created: {{ optional($p->created_at)->format('d M Y') }}</span>
        </div>
        <div class="mt-4 flex gap-2">
            <a href="#" class="px-3 py-1.5 rounded-lg border border-slate-300 text-slate-700 text-sm hover:bg-slate-50">Open</a>
            <a href="#" class="px-3 py-1.5 rounded-lg border border-slate-300 text-slate-700 text-sm hover:bg-slate-50">Manage</a>
        </div>
    </div>
    @empty
    <div class="col-span-full bg-white border border-slate-200 rounded-xl shadow-sm p-6 text-center text-slate-500">No projects found.</div>
    @endforelse
</div>

<div class="mt-6">
    {{ method_exists($projects, 'links') ? $projects->links() : '' }}
</div>
@endsection