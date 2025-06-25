@php
    $alerts = [
        'success' => ['class' => 'text-bg-success', 'icon' => 'fa-circle-check'],
        'error'   => ['class' => 'text-bg-danger',  'icon' => 'fa-circle-xmark'],
        'info'    => ['class' => 'text-bg-info',    'icon' => 'fa-circle-info'],
        'warning' => ['class' => 'text-bg-warning', 'icon' => 'fa-triangle-exclamation'],
    ];
@endphp

<div class="position-fixed top-0 end-0 p-3" style="z-index: 1080; margin-top: 70px;">
    @foreach ($alerts as $type => $data)
        @if (session($type))
            <div class="toast align-items-center {{ $data['class'] }} border-0 show mb-2" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa-solid {{ $data['icon'] }} me-2"></i>
                        {{ session($type) }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    @endforeach
</div>

@if (session('success'))
    <script>
        window.dispatchEvent(new Event('registerSuccess'));
    </script>
@endif