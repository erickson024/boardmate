@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "btn btn-sm btn-{$variant}"]) }} wire:navigate>
        <small>{{ $slot }}</small>
    </a>
@else
    <button type="submit" {{ $attributes->merge(['class' => "btn btn-sm btn-{$variant}"]) }}>
        <span wire:loading.remove wire:target="{{ $action }}">
            <small>{{ $slot }}</small>
        </span>

        @if($action)
            <span wire:loading wire:target="{{ $action }}">
                <small>
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                </small>
            </span>
        @endif
    </button>
@endif
