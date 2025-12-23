@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Create Meeting</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.meetings.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                </div>
                <div class="mb-3">
                    <label for="scheduled_at" class="form-label">Date & Time</label>
                    <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at') }}">
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Duration (min)</label>
                    <input type="number" class="form-control" id="duration" name="duration" value="{{ old('duration') }}">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="physical">Physical</option>
                        <option value="video">Video</option>
                        <option value="audio">Audio</option>
                        <option value="chats">Chats</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message">{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="{{ route('admin.meetings.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
