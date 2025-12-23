@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Meeting Details</h3>
        </div>
        <div class="card-body">
            <h4>{{ $meeting->title }}</h4>
            <p><strong>Customer:</strong> {{ $meeting->customer->name ?? 'N/A' }}</p>
            <p><strong>Company:</strong> {{ $meeting->seller->company_name ?? $meeting->manufacturer->company_name ?? 'N/A' }}</p>
            <p><strong>Date & Time:</strong> {{ $meeting->scheduled_at ? $meeting->scheduled_at->format('d M Y, g:i A') : 'N/A' }}</p>
            <p><strong>Duration:</strong> {{ $meeting->duration ? $meeting->duration . ' min' : 'N/A' }}</p>
            <p><strong>Type:</strong> {{ ucfirst($meeting->type) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($meeting->status) }}</p>
            <p><strong>Message:</strong> {{ $meeting->message }}</p>
            <a href="{{ route('admin.meetings.edit', $meeting->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.meetings.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
