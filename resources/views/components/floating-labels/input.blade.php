<div wire:ignore>

    <div class="form-floating position-relative">
        <input
            type="{{ $type }}"
            class="form-control"
            id="{{ $id }}"
            placeholder="{{ $label }}"
            {{ $attributes->merge([]) }}> <!--make native HTML attributes work properly-->


        <label
            for="{{ $id }}"
            class="fw-medium small">
            <small>{{ $label }}</small>
        </label>

        @if($type === 'password')
        <button
            type="button"
            class="btn btn-sm btn-dark position-absolute top-50 end-0 translate-middle-y me-2 text-light"
            onclick="togglePassword('{{ $id }}', this)"
            tabindex="-1">
            <i class="bi bi-eye-fill"></i>
        </button>
        @endif
    </div>
</div>

@error($id)
<div class="text-danger small">
    <small>{{ $message }}</small>
</div>
@enderror