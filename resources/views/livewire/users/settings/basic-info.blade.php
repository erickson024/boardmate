<div>
    <div class="row mb-3">
        <div class="col-12">
            <h6 class="mb-0">Profile</h6>
            <small class="mt-0">Update your first and last name.</small>
        </div>
    </div>
    <form wire:submit.prevent="updateBasicInfo">
        <div class="row">
            <div class="col-6">
                <x-floating-labels.input
                    id="firstName"
                    label="First Name"
                    type="text"
                    wire:model="firstName"
                    wire:loading.attr="disabled"
                    wire:target=""
                    required />
            </div>
            <div class="col-6">
                <x-floating-labels.input
                    id="lastName"
                    label="Last Name"
                    type="text"
                    wire:model="lastName"
                    wire:loading.attr="disabled"
                    wire:target=""
                    required />
            </div>
            <div class="col-12 d-flex align-items-center gap-2 mt-3 mb-3">
                <x-buttons.small-button
                    type="submit"
                    action="updateBasicInfo"
                    class="w-25 fw-semibold"
                    wire:loading.attr="disabled"
                    wire:target="updateBasicInfo">
                    Update
                </x-buttons.small-button>
            </div>

            <div class="col-12">
                @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <small>{{ session('message') }}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>
        </div>
    </form>
</div>