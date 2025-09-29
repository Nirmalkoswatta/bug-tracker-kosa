@extends('layouts.admin')
@php($section='overview')
@section('admin-content')
<div class="card-grid">
    <div class="ui-card">
        <div class="fw-bold">Open Bugs</div>
        <div class="display-6">{{ $metrics['open'] ?? 0 }}</div>
    </div>
    <div class="ui-card">
        <div class="fw-bold">Assigned</div>
        <div class="display-6">{{ $metrics['assigned'] ?? 0 }}</div>
    </div>
    <div class="ui-card">
        <div class="fw-bold">In QA</div>
        <div class="display-6">{{ $metrics['in_qa'] ?? 0 }}</div>
    </div>
    <div class="ui-card">
        <div class="fw-bold">Resolved</div>
        <div class="display-6">{{ $metrics['resolved'] ?? 0 }}</div>
    </div>
    <div class="ui-card">
        <div class="fw-bold">Developers</div>
        <div class="display-6">{{ $developers->count() }}</div>
    </div>
    <div class="ui-card">
        <div class="fw-bold">QAs</div>
        <div class="display-6">{{ $qas->count() }}</div>
    </div>
    <div class="ui-card">
        <div class="fw-bold">PMs</div>
        <div class="display-6">{{ $pms->count() }}</div>
    </div>
</div>
@endsection