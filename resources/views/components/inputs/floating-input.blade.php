<div class="mb-3">
    <div class="form-floating">
        @if($type === 'password')
        <input
            type="{{ $type }}"
            id="{{ $id }}"
            wire:model.live="{{ $model }}"
            class="form-control border-1 shadow-sm"
            style="font-size: 15px;"
            placeholder="{{ $label }}"
            required>
        <label for="{{ $id }}" class="small fw-medium"> <small>{{ $label }}</small> </label>
        <button
            type="button"
            class="btn btn-sm btn-dark position-absolute top-50 end-0 translate-middle-y me-2 text-light"
            onclick="togglePassword('{{ $id }}', this)"
            tabindex="-1">
            <i class="bi bi-eye-fill"></i>
        </button>
        @else
        <input
            type="{{ $type }}"
            id="{{ $id }}"
            wire:model="{{ $model }}"
            class="form-control border-1 shadow-sm"
            style="font-size: 15px;"
            placeholder="{{ $label }}"
            required>
        <label for="{{ $id }}" class="small fw-medium"> <small>{{ $label }}</small> </label>
        @endif
    </div>
    @error($model)
    <small class="text-danger ">{{ $message }}</small>
    @enderror
</div>

<script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye-fill");
            icon.classList.add("bi-eye-slash-fill");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash-fill");
            icon.classList.add("bi-eye-fill");
        }
    }
</script>