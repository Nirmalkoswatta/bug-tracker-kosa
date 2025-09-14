@extends('layouts.app')

@section('content')
<div class="container" style='margin-top: 90px; max-width: 1200px; min-width: 320px; width: 100%; background-image: url("{{ asset('10780356_19199649.jpg') }}"); background-repeat: no-repeat; background-position: center center; background-attachment: fixed; background-size: cover; min-height: 100vh; color: #fff;'>
    <div class="text-center mb-4">
        <h2 class="font-bold text-2xl">Developer Dashboard</h2>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bugs as $bug)
            <tr>
                <td>{{ $bug->id }}</td>
                <td>{{ $bug->title }}</td>
                <td>{{ $bug->status }}</td>
                <td>
                    <a href="{{ route('bugs.edit', $bug) }}" class="btn btn-warning btn-sm">Update Status</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection