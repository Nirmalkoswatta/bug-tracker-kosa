@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Admin Dashboard</h2>
    <p>Admin can manage all bugs, users, and permissions here.</p>

    <h4 class="mt-4">Developers</h4>
    <table class="table table-bordered mb-4">
        <thead>
                <h2>Admin Dashboard</h2>
                <div class="container mt-5" style="background: url('{{ asset('10780356_19199649.jpg') }}') no-repeat center center fixed; background-size: cover; min-height: 100vh;">
                <th>Name</th>
                <th>Email</th>
                <th>Can Access QAs</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($developers as $dev)
            <tr>
                <td>{{ $dev->name }}</td>
                <td>{{ $dev->email }}</td>
                <td>
                    @if($dev->can_access_qas)
                        <span class="badge bg-success">Yes</span>
                    @else
                        <span class="badge bg-secondary">No</span>
                    @endif
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.toggleQAs', $dev->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary">
                            {{ $dev->can_access_qas ? 'Revoke' : 'Allow' }}
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4>QAs</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($qas as $qa)
            <tr>
                <td>{{ $qa->name }}</td>
                <td>{{ $qa->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection