@extends('frontend.layout.main')
@section('content')
<div class="container py-5 text-center">
    <h3 class="mb-4">{{ $meeting->title ?? 'Meeting Room' }}</h3>
    <div id="jitsi-container" style="height: 600px; width: 100%;"></div>
</div>

<script src="https://meet.jit.si/external_api.js"></script>
<script>
    const domain = "meet.jit.si";
    const options = {
        roomName: "{{ $roomName }}",
        width: "100%",
        height: 600,
        parentNode: document.querySelector('#jitsi-container'),
        userInfo: {
            displayName: "{{ $user->name }}"
        }
    };
    const api = new JitsiMeetExternalAPI(domain, options);
</script>
@endsection
