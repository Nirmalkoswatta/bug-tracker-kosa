@extends('layouts.app')

@section('content')
<div class="container mt-5" style="background: url('{{ asset('10780356_19199649.jpg') }}') no-repeat center center fixed; background-size: cover; min-height: 100vh;">
    <h2>Project Manager Dashboard</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Created By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bugs as $bug)
            <tr>
                <td>{{ $bug->id }}</td>
                <td>{{ $bug->title }}</td>
                <td>{{ $bug->status }}</td>
                <td>{{ optional($bug->assignedTo)->name }}</td>
                <td>{{ optional($bug->creator)->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection