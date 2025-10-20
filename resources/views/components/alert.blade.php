@if ($message)
    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
        <i class="fas {{ $type === 'success' ? 'fa-check-circle' : ($type === 'danger' ? 'fa-times-circle' : 'fa-info-circle') }} me-2"></i>
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
{{-- Usage Example:
    <x-alert type="success" :message="session('success')" />
    <x-alert type="danger" :message="session('error')" />
    <x-alert type="info" :message="session('info')" />
--}}
