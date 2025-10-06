<div class="container-fluid bg-light rounded p-5" style="height: 85vh;">
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
                <button type="button" wire:click="setTab('profile')" class="btn btn-sm text-start flex-fill flex-md-none {{ $active==='profile' ? 'btn-dark' : 'btn-outline-dark' }}">Profile</button>
                <button type="button" wire:click="setTab('password')" class="btn btn-sm text-start flex-fill flex-md-none {{ $active==='password' ? 'btn-dark' : 'btn-outline-dark' }}">Password</button>
                <button type="button" wire:click="setTab('email')" class="btn btn-sm text-start flex-fill flex-md-none {{ $active==='email' ? 'btn-dark' : 'btn-outline-dark' }}">Email</button>
                <button type="button" wire:click="setTab('delete')" class="btn btn-sm text-start flex-fill flex-md-none {{ $active==='delete' ? 'btn-dark' : 'btn-outline-dark' }}">Delete</button>
                <button type="button" wire:click="setTab('appearance')" class="btn btn-sm text-start flex-fill flex-md-none {{ $active==='appearance' ? 'btn-dark' : 'btn-outline-dark' }}">Appearance</button>
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
</div>