@extends('layouts.clean')
@section('content')
<div class="mb-4">
    <h2 class="text-2xl font-bold text-slate-800">Settings</h2>
    <p class="text-slate-500 text-sm">Manage users and roles.</p>
</div>
<div class="bg-white border border-slate-200 rounded-xl shadow-sm">
    <div class="p-4 border-b border-slate-200 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-slate-800">All Users</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $u)
                <tr class="hover:bg-slate-50">
                    <td class="px-4 py-2 text-slate-800">{{ $u->name }}</td>
                    <td class="px-4 py-2 text-slate-700">{{ $u->email }}</td>
                    <td class="px-4 py-2">{{ $u->role }}</td>
                    <td class="px-4 py-2">
                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete user {{ $u->name }}?')" class="inline">
                            @csrf @method('DELETE')
                            <button class="inline-flex items-center gap-1 text-rose-600 hover:text-rose-700 text-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection