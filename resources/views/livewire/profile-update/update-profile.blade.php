<div class="container-fluid">
    <div class="row bg-white shadow p-4 rounded">
        <div class="col-md-12">
            <h5 class="mb-0 fw-semibold">Profile Information</h5>
            <small class="text-muted">Manage your profile and account settings.</small>
            <hr class="my-4 border-secondary">
        </div>

        <!-- Sidebar: use Livewire tab switching -->
        <div class="col-md-3 d-flex flex-column gap-3">
            <button type="button" wire:click="setTab('profile')" class="btn btn-sm text-start {{ $active==='profile' ? 'btn-dark' : 'btn-outline-dark' }}">Profile</button>
            <button type="button" wire:click="setTab('password')" class="btn btn-sm text-start {{ $active==='password' ? 'btn-dark' : 'btn-outline-dark' }}">Password</button>
            <button type="button" wire:click="setTab('email')" class="btn btn-sm text-start {{ $active==='email' ? 'btn-dark' : 'btn-outline-dark' }}">Email</button>
            <button type="button" wire:click="setTab('delete')" class="btn btn-sm text-start {{ $active==='delete' ? 'btn-dark' : 'btn-outline-dark' }}">Delete</button>
            <button type="button" wire:click="setTab('appearance')" class="btn btn-sm text-start {{ $active==='appearance' ? 'btn-dark' : 'btn-outline-dark' }}">Appearance</button>
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
                <h6>Deleting Account</h6>
                <p>Delete your account and all of its resources.</p>
            @elseif ($active === 'appearance')
                <h6>Appearance Settings</h6>
                <p>Customize the theme and layout.</p>
            @endif
        </div>
    </div>
</div>

