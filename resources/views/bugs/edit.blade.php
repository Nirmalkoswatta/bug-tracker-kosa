@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4">
    <style>
        .edit-bug-wrapper {
            min-height: calc(100vh - 120px);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .edit-bug-panel {
            width: 100%;
            max-width: 760px;
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 24px;
            padding: 2.2rem 2.1rem 2rem;
            box-shadow: 0 10px 28px -6px rgba(0, 0, 0, 0.55);
            position: relative;
        }

        .edit-bug-panel h2 {
            font-weight: 600;
            letter-spacing: .5px;
            color: #fff !important;
        }

        .edit-bug-panel label.form-label {
            color: #fff !important;
            font-weight: 500;
        }

        .edit-bug-panel small.helper-text {
            color: #cfd8dc;
            font-size: .72rem;
            letter-spacing: .5px;
            text-transform: uppercase;
            display: block;
            margin-top: -.25rem;
            margin-bottom: .75rem;
        }

        .edit-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #ffffff55, transparent);
            margin: .9rem 0 1.35rem;
        }

        .file-preview-box img {
            border: 1px solid rgba(255, 255, 255, 0.35);
        }

        @media (max-width: 575.98px) {
            .edit-bug-panel {
                padding: 1.65rem 1.2rem 1.2rem;
                border-radius: 18px;
            }
        }
    </style>
    <div class="edit-bug-wrapper py-4 py-md-5">
        <div class="edit-bug-panel">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                <h2 class="mb-0">Edit Bug</h2>
                @if((Auth::user()->role === 'QA' && $bug->created_by === Auth::id()) || Auth::user()->role === 'Admin')
                <form method="POST" action="{{ route('bugs.destroy', $bug) }}" onsubmit="return confirm('Are you sure you want to delete this bug?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" style="border-radius:18px;">Delete</button>
                </form>
                @endif
            </div>
            <div class="edit-divider"></div>
            <form method="POST" action="{{ route('bugs.update', $bug) }}" enctype="multipart/form-data" class="mb-0">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $bug->title }}" @if(Auth::user()->role!=='QA' && Auth::user()->role!=='Admin') readonly @endif>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" @if(Auth::user()->role!=='QA' && Auth::user()->role!=='Admin') readonly @endif>{{ $bug->description }}</textarea>
                </div>
                @if(Auth::user()->role === 'Admin')
                <div class="mb-3">
                    <label for="assigned_to" class="form-label">Assigned Developer</label>
                    <select class="form-control" id="assigned_to" name="assigned_to">
                        @foreach($devs as $dev)
                        <option value="{{ $dev->id }}" @if($bug->assigned_to == $dev->id) selected @endif>{{ $dev->name }} ({{ $dev->email }})</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="inprogress" {{ $bug->status == 'inprogress' ? 'selected' : '' }}>In Progress</option>
                        <option value="review" {{ $bug->status == 'review' ? 'selected' : '' }}>Review</option>
                        <option value="done" {{ $bug->status == 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>
                @if($bug->attachment)
                @php
                $ext = strtolower(pathinfo($bug->attachment, PATHINFO_EXTENSION));
                $imgExts = ['jpg','jpeg','png','gif','bmp','webp'];
                @endphp
                @if(Auth::user()->role === 'Dev' && $bug->assigned_to === Auth::id())
                <div class="mb-3" id="file-preview-box">
                    <label class="form-label">QA Uploaded File:</label>
                    <button type="button" class="btn-close float-end" aria-label="Close" onclick="document.getElementById('file-preview-box').style.display='none';"></button>
                    @if(in_array($ext, $imgExts))
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $bug->attachment) }}" alt="QA Uploaded Image" style="max-width: 300px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 8px #0002;">
                    </div>
                    @else
                    <a href="{{ asset('storage/' . $bug->attachment) }}" target="_blank" class="btn btn-info btn-sm">View Document</a>
                    @endif
                    <a href="{{ route('bugs.download', $bug) }}" class="btn btn-success btn-sm">Download File</a>
                </div>
                @endif
                @if(Auth::user()->role === 'QA' && $bug->created_by === Auth::id())
                <div class="mb-3" id="file-preview-box-qa">
                    <label class="form-label">QA Uploaded File:</label>
                    <button type="button" class="btn-close float-end" aria-label="Close" onclick="document.getElementById('file-preview-box-qa').style.display='none';"></button>
                    @if(in_array($ext, $imgExts))
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $bug->attachment) }}" alt="QA Uploaded Image" style="max-width: 300px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 8px #0002;">
                    </div>
                    <a href="{{ asset('storage/' . $bug->attachment) }}" target="_blank" class="btn btn-info btn-sm">View Full Image</a>
                    @else
                    <a href="{{ asset('storage/' . $bug->attachment) }}" target="_blank" class="btn btn-info btn-sm">View Document</a>
                    @endif
                    <a href="{{ route('bugs.download', $bug) }}" class="btn btn-success btn-sm">Download File</a>
                    <a href="{{ route('bugs.edit', $bug) }}?editfile=1" class="btn btn-secondary btn-sm">Edit/Update File</a>
                </div>
                @endif
                @if(Auth::user()->role === 'Admin' && $bug->attachment)
                @php
                $ext = strtolower(pathinfo($bug->attachment, PATHINFO_EXTENSION));
                $imgExts = ['jpg','jpeg','png','gif','bmp','webp'];
                @endphp
                <div class="mb-3" id="file-preview-box-admin">
                    <label class="form-label">Attachment:</label>
                    @if(in_array($ext, $imgExts))
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $bug->attachment) }}" alt="Attachment Image" style="max-width: 300px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 8px #0002;">
                    </div>
                    <a href="{{ asset('storage/' . $bug->attachment) }}" target="_blank" class="btn btn-info btn-sm">View Full Image</a>
                    @else
                    <a href="{{ asset('storage/' . $bug->attachment) }}" target="_blank" class="btn btn-info btn-sm">View Document</a>
                    @endif
                    <a href="{{ route('bugs.download', $bug) }}" class="btn btn-success btn-sm">Download File</a>
                </div>
                @endif
                @endif
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-light" style="--bs-btn-color:#fff; --bs-btn-border-color:#ffffff55; --bs-btn-hover-bg:#ffffff22; border-radius:18px;">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4" style="border-radius:18px;">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection