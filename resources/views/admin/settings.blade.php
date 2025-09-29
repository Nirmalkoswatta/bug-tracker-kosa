@extends('layouts.admin')
@php($section='settings')
@section('admin-content')
<h4 class="mb-3">Settings</h4>
<div class="ui-card">
    <div class="fw-bold mb-2">All Users</div>
    <div class="table-responsive">
        <table class="table table-sm align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.update',$u->id) }}" class="d-flex gap-1 align-items-center">
                            @csrf @method('PATCH')
                            <select name="role" class="form-select form-select-sm" aria-label="Change role for {{ $u->name }}">
                                <option value="QA" @selected($u->role==='QA')>QA</option>
                                <option value="Dev" @selected($u->role==='Dev')>Dev</option>
                                <option value="PM" @selected($u->role==='PM')>PM</option>
                                <option value="Admin" @selected($u->role==='Admin')>Admin</option>
                            </select>
                            <button class="btn btn-sm btn-outline-primary" aria-label="Save role for {{ $u->name }}">Save</button>
                        </form>
                    </td>
                    <td class="text-nowrap">
                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete user {{ $u->name }}?')" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" aria-label="Delete user {{ $u->name }}">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection