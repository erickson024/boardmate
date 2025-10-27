<div class="container-fluid p-5">

    <div class="row rounded">
        <div class="col-md-12">
            <h5 class="mb-0 fw-semibold">Profile Information</h5>
            <small class="text-muted">Manage your profile and account settings.</small>
            <hr class="my-4 border-secondary">
        </div>
    </div>

    <div class="row rounded gx-5">
        <!-- Sidebar: use Livewire tab switching -->
        <div class="col-12 col-md-3 mb-3 mb-md-0">
            <div class="d-flex flex-row flex-md-column gap-2 gap-md-3 overflow-auto">
                <button
                    type="button"
                    wire:click="setTab('profile')"
                    wire:target="setTab('profile')"
                    wire:loading.attr="disabled"
                    class="btn btn-sm text-start flex-fill flex-md-none {{ $active==='profile' ? 'btn-dark' : 'btn-outline-dark' }}">
                    Profile
                    <span wire:loading wire:target="setTab('profile')">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    </span>
                </button>

                <button
                    type="button"
                    wire:click="setTab('password')"
                    wire:target="setTab('password')"
                    wire:loading.attr="disabled"
                    class="btn btn-sm text-start flex-fill flex-md-none {{ $active==='password' ? 'btn-dark' : 'btn-outline-dark' }}">
                    Password
                    <span wire:loading wire:target="setTab('password')">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    </span>
                </button>

                <button
                    type="button"
                    wire:click="setTab('email')"
                    wire:target="setTab('email')"
                    wire:loading.attr="disabled"
                    class="btn btn-sm text-start flex-fill flex-md-none {{ $active==='email' ? 'btn-dark' : 'btn-outline-dark' }}">
                    Email
                    <span wire:loading wire:target="setTab('email')">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    </span>
                </button>

                <button
                    type="button"
                    wire:click="setTab('delete')"
                    wire:target="setTab('delete')"
                    wire:loading.attr="disabled"
                    class="btn btn-sm text-start flex-fill flex-md-none {{ $active==='delete' ? 'btn-dark' : 'btn-outline-dark' }}">
                    Delete
                    <span wire:loading wire:target="setTab('delete')">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    </span>
                </button>

                <button
                    type="button"
                    wire:click="setTab('appearance')"
                    wire:target="setTab('appearance')"
                    wire:loading.attr="disabled"
                    class="btn btn-sm text-start flex-fill flex-md-none {{ $active==='appearance' ? 'btn-dark' : 'btn-outline-dark' }}">
                    Appearance
                    <span wire:loading wire:target="setTab('appearance')">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    </span>
                </button>
                
            </div>
        </div>

        <!-- Content area -->
        <div class="col-md-9">
            @if ($active === 'profile')
            <livewire:profile-update.profile-form />
            @elseif ($active === 'password')
            <livewire:profile-update.password-form />
            @elseif ($active === 'email')
            <livewire:profile-update.email-form />
            @elseif ($active === 'delete')
            <livewire:profile-update.delete-form />
            @elseif ($active === 'appearance')
            <h6>Appearance Settings</h6>
            <p>Customize the theme and layout.</p>
            @endif
        </div>
    </div>

        </style>

    <script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }
</script>
</div>