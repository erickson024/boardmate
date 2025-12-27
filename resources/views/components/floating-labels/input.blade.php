<div>
    @if($type === 'password')
    <div class="form-floating">
        <input type="{{ $type }}" class="form-control" id="{{ $id }}" placeholder="{{ $label }}">
        <label for="{{ $id }}" class="fw-medium small">{{ $label }}</label>
        <button
            type="button"
            class="btn btn-sm btn-dark position-absolute top-50 end-0 translate-middle-y me-2 text-light"
            onclick="togglePassword('{{ $id }}', this)"
            tabindex="-1">
            <i class="bi bi-eye-fill"></i>
        </button>
    </div>

    // Password toggle script
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
    @else
    <div class="form-floating">
        <input type="{{ $type }}" class="form-control" id="{{ $id }}" placeholder="{{ $label }}">
        <label for="{{ $id }}" class="fw-medium small">{{ $label }}</label>
    </div>
    @endif
</div>