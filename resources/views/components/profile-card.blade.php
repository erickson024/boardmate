<div class="profile-card shadow rounded-4 p-3 position-relative mb-3">

    <!-- Notification Bell (top-right) -->
    <x-buttons.small-button
        class="position-absolute top-0 end-0 m-3 d-flex justify-content-center align-items-center"
        style="z-index: 10;"
        href="">
        <i class="bi bi-gear"></i>
    </x-buttons.small-button>


    <!-- Profile Image -->
    <div class="d-flex justify-content-center mb-3 mt-2">
        <x-profile-image size="100" />
    </div>

    <!-- Name + Email -->
    <div class="lh-1">
        <h6 class="fw-semibold mb-1 text-center">
            {{ $user->firstName }} {{ $user->lastName }}
        </h6>
        <p class="text-muted small mb-4 text-center">
            <small>{{ $user->email ?? '' }}</small>
        </p>
    </div>

    <!-- Bottom Buttons -->
    <div class="row gx-2">
        <div class="col-6">
            <x-buttons.small-button
                class="w-100 d-flex justify-content-center align-items-center gap-1"
                href="">
                Profile
            </x-buttons.small-button>
        </div>

        <div class="col-6">
            <x-buttons.small-button
                class="w-100 d-flex justify-content-center align-items-center gap-1"
                href="">
                Messages
            </x-buttons.small-button>
        </div>
    </div>
</div>