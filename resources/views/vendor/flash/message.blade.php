@foreach (session('flash_notification', collect())->toArray() as $message)
    @php
        if ($message['level'] == 'success') {
            $icon = '<i class="icon fas fa-check"></i>';
        } elseif ($message['level'] == 'warning') {
            $icon = '<i class="icon fas fa-exclamation-triangle"></i>';
        } elseif ($message['level'] == 'info') {
            $icon = '<i class="icon fas fa-info"></i>';
        } elseif ($message['level'] == 'danger') {
            $icon = '<i class="icon fas fa-ban"></i>';
        }
    @endphp

    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="alert flash-message
                    alert-{{ $message['level'] }}
                    alert-dismissible
                    {{ $message['important'] ? 'alert-important' : '' }}"
                    role="alert"
        >
            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-hidden="true"
            >&times;</button>

            {!! $icon !!} {!! $message['message'] !!}
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
