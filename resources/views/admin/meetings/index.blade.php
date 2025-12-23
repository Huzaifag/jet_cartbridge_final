@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>All Meetings</h3>
            <a href="{{ route('admin.meetings.create') }}" class="btn btn-primary float-end">New Meeting</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Customer</th>
                        <th>Company</th>
                        <th>Date & Time</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($meetings as $meeting)
                        <tr>
                            <td>{{ $meeting->title }}</td>
                            <td>{{ $meeting->customer->name ?? 'N/A' }}</td>
                            <td>{{ $meeting->seller->company_name ?? $meeting->manufacturer->company_name ?? 'N/A' }}</td>
                            <td>{{ $meeting->scheduled_at ? $meeting->scheduled_at->format('d M Y, g:i A') : 'N/A' }}</td>
                            <td>{{ ucfirst($meeting->type) }}</td>
                            <td>{{ ucfirst($meeting->status) }}</td>
                            <td>
                                <a href="{{ route('admin.meetings.show', $meeting->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('admin.meetings.edit', $meeting->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
