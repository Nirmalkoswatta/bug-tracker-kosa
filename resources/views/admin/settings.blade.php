@extends('layouts.admin')
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
                    <td>{{ $u->role }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Delete user {{ $u->name }}?')" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection