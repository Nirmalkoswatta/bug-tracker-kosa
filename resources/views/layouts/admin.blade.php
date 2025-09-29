@extends('layouts.app')
@section('content')
<style>
    .admin-shell {
        display: flex;
        gap: 0;
        min-height: calc(100vh - var(--nav-h, 88px));
    }

    .admin-sidebar {
        width: 240px;
        background: #0f172a;
        border: 1px solid #1e293b;
        border-left: 0;
        border-bottom: 0;
        border-top: 0;
        position: sticky;
        top: calc(var(--nav-h, 88px) + 0px);
        height: calc(100vh - var(--nav-h, 88px));
        padding: 8px 0;
    }

    .admin-sidebar a {
        display: flex;
        align-items: center;
        gap: .55rem;
        padding: .55rem 1rem;
        color: #cbd5e1;
        text-decoration: none;
        font-weight: 500;
        font-size: .9rem;
        border-left: 3px solid transparent;
        transition: .18s;
        outline: 2px solid transparent;
        outline-offset: 2px;
    }

    .admin-sidebar a:hover,
    .admin-sidebar a:focus {
        background: #1e293b;
        color: #fff;
    }

    .admin-sidebar a:focus-visible {
        outline: 2px solid #0d9488;
    }

    .admin-sidebar a.active {
        background: #164e63;
        color: #fff;
        border-left-color: #0d9488;
    }

    .admin-main {
        flex: 1;
        padding: 8px 16px 40px;
    }

    @media (max-width: 900px) {
        .admin-shell {
            flex-direction: column;
        }

        .admin-sidebar {
            width: 100%;
            height: auto;
            display: flex;
            position: relative;
            top: auto;
        }

        .admin-sidebar nav {
            display: flex;
            overflow-x: auto;
        }

        .admin-sidebar a {
            flex: 0 0 auto;
        }
    }

    .alert-role {
        position: relative;
    }

    .alert:focus {
        outline: 2px solid #0d9488;
        outline-offset: 2px;
    }
</style>
<div class="admin-shell">
    <aside class="admin-sidebar" aria-label="Admin navigation">
        <nav class="w-100">
            @php $section = $section ?? ''; @endphp
            <a href="{{ route('admin.overview') }}" class="{{ $section==='overview'?'active':'' }}" aria-current="{{ $section==='overview'?'page':'false' }}">Overview</a>
            <a href="{{ route('admin.projects') }}" class="{{ $section==='projects'?'active':'' }}" aria-current="{{ $section==='projects'?'page':'false' }}">Projects</a>
            <a href="{{ route('admin.bugs') }}" class="{{ $section==='bugs'?'active':'' }}" aria-current="{{ $section==='bugs'?'page':'false' }}">Bugs</a>
            <a href="{{ route('admin.users') }}" class="{{ $section==='users'?'active':'' }}" aria-current="{{ $section==='users'?'page':'false' }}">Users</a>
            <a href="{{ route('admin.settings') }}" class="{{ $section==='settings'?'active':'' }}" aria-current="{{ $section==='settings'?'page':'false' }}">Settings</a>
        </nav>
    </aside>
    <div class="admin-main">
        @yield('admin-content')
    </div>
</div>
@endsection