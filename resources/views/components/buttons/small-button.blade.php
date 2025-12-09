<button type="{{ $type }}" {{ $attributes->merge(['class' => 'btn btn-sm btn-dark']) }}>
    <small>{{ $slot }}</small>
</button>