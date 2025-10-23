@extends('layouts.admin')
@section('admin-content')
<div class="max-w-2xl">
    <h2 class="text-2xl font-bold text-slate-800 mb-4">{{ $project->exists ? 'Edit Project' : 'Add Project' }}</h2>
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}">
            @csrf
            @if($project->exists)
            @method('PUT')
            @endif
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                <input name="name" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300" value="{{ old('name', $project->name) }}" required />
                @error('name')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full border border-slate-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300">{{ old('description', $project->description) }}</textarea>
                @error('description')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="flex gap-2">
                <button class="px-4 py-2 rounded-lg bg-slate-800 text-white hover:bg-slate-900">{{ $project->exists ? 'Update' : 'Create' }}</button>
                <a href="{{ route('admin.projects') }}" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-50">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection