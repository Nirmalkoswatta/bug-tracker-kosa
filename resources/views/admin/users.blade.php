@extends('layouts.clean')
@section('content')
<div class="flex flex-col gap-4">
    <!-- Header + Add User Form -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Users</h2>
            <p class="text-slate-500 text-sm">Manage your team members by role.</p>
        </div>
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
            <button class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">Add</button>
        </form>
    </div>

    <!-- Columns: Devs, QAs, PMs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Developers -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-slate-800">Developers</h3>
                <span class="text-xs font-semibold bg-slate-100 text-slate-700 px-2 py-1 rounded-full">{{ $developers->count() }}</span>
            </div>
            <div class="space-y-2">
                @forelse($developers as $u)
                <div class="flex items-center justify-between border border-slate-200 rounded-lg p-2">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold">{{ strtoupper(substr($u->name,0,1)) }}</div>
                        <div>
                            <div class="font-semibold text-slate-800">{{ $u->name }}</div>
                            <div class="text-xs text-slate-500">{{ $u->email }}</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete user {{ $u->name }}?')">
                        @csrf @method('DELETE')
                        <button class="text-rose-600 hover:text-rose-700 text-sm">Delete</button>
                    </form>
                </div>
                @empty
                <div class="text-slate-500 text-sm">No developers.</div>
                @endforelse
            </div>
        </div>

        <!-- QAs -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-slate-800">QAs</h3>
                <span class="text-xs font-semibold bg-slate-100 text-slate-700 px-2 py-1 rounded-full">{{ $qas->count() }}</span>
            </div>
            <div class="space-y-2">
                @forelse($qas as $u)
                <div class="flex items-center justify-between border border-slate-200 rounded-lg p-2">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold">{{ strtoupper(substr($u->name,0,1)) }}</div>
                        <div>
                            <div class="font-semibold text-slate-800">{{ $u->name }}</div>
                            <div class="text-xs text-slate-500">{{ $u->email }}</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete user {{ $u->name }}?')">
                        @csrf @method('DELETE')
                        <button class="text-rose-600 hover:text-rose-700 text-sm">Delete</button>
                    </form>
                </div>
                @empty
                <div class="text-slate-500 text-sm">No QAs.</div>
                @endforelse
            </div>
        </div>

        <!-- PMs -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-slate-800">Project Managers</h3>
                <span class="text-xs font-semibold bg-slate-100 text-slate-700 px-2 py-1 rounded-full">{{ $pms->count() }}</span>
            </div>
            <div class="space-y-2">
                @forelse($pms as $u)
                <div class="flex items-center justify-between border border-slate-200 rounded-lg p-2">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold">{{ strtoupper(substr($u->name,0,1)) }}</div>
                        <div>
                            <div class="font-semibold text-slate-800">{{ $u->name }}</div>
                            <div class="text-xs text-slate-500">{{ $u->email }}</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete user {{ $u->name }}?')">
                        @csrf @method('DELETE')
                        <button class="text-rose-600 hover:text-rose-700 text-sm">Delete</button>
                    </form>
                </div>
                @empty
                <div class="text-slate-500 text-sm">No PMs.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection