@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Edit Meeting</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.meetings.update', $meeting->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $meeting->title) }}" required>
                </div>
                <div class="mb-3">
                    <label for="scheduled_at" class="form-label">Date & Time</label>
                    <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at', $meeting->scheduled_at ? $meeting->scheduled_at->format('Y-m-d\TH:i') : '') }}">
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Duration (min)</label>
                    <input type="number" class="form-control" id="duration" name="duration" value="{{ old('duration', $meeting->duration) }}">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type">
                        <option value="physical" @if($meeting->type=='physical') selected @endif>Physical</option>
                        <option value="video" @if($meeting->type=='video') selected @endif>Video</option>
                        <option value="audio" @if($meeting->type=='audio') selected @endif>Audio</option>
                        <option value="chats" @if($meeting->type=='chats') selected @endif>Chats</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message">{{ old('message', $meeting->message) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.meetings.show', $meeting->id) }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
