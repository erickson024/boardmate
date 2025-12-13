<div class="container-fluid">
    <div class="row">
        <div class="col-2 p-0 bg-primary">
            <nav class="nav flex-column bg-body-tertiary shadow-sm border p-3 vh-100">
                <div class="d-flex justify-content-center">
                    <span class=" fw-semibold" style="font-size: 12px;">Boardmate Admin Panel</span>
                </div>

                <div class="d-flex flex-column gap-2 mt-4">

                    <!--Environment Status-->
                    <button
                        type="button"
                        wire:click="setTab('environment')"
                        wire:loading.attr="disabled"
                        class="btn btn-sm btn-dark fw-semibold w-100 d-flex justify-content-between align-items-center  {{ $active === 'environment' ? 'active' : '' }}">

                        <small><small>Environment Status</small></small>

                        {{-- Icon (normal state) --}}
                        <span
                            wire:loading.remove
                            wire:target="setTab('environment')">
                            <i class="bi bi-bar-chart-fill"></i>
                        </span>

                        {{-- Spinner (loading state) --}}
                        <span
                            wire:loading
                            wire:target="setTab('environment')"
                            class="spinner-border spinner-border-sm">
                        </span>
                    </button>

                    <!--Host Request-->
                    <button
                        type="button"
                        wire:click="setTab('host')"
                        wire:loading.attr="disabled"
                        class="btn btn-sm btn-dark fw-semibold w-100 d-flex justify-content-between align-items-center {{ $active === 'host' ? 'active' : '' }}">

                        <small><small>Host Request</small></small>


                        {{-- Icon (normal state) --}}
                        <span
                            wire:loading.remove
                            wire:target="setTab('host')">
                            0
                        </span>

                        {{-- Spinner (loading state) --}}
                        <span
                            wire:loading
                            wire:target="setTab('host')"
                            class="spinner-border spinner-border-sm">
                        </span>
                    </button>

                    <!--User List-->
                    <button
                        type="button"
                        wire:click="setTab('users')"
                        wire:loading.attr="disabled"
                        class="btn btn-sm btn-dark fw-semibold w-100 d-flex justify-content-between align-items-center {{ $active === 'users' ? 'active' : '' }}">

                        <small><small>Users List</small></small>


                        {{-- Icon (normal state) --}}
                        <span
                            wire:loading.remove
                            wire:target="setTab('users')">
                            0
                        </span>

                        {{-- Spinner (loading state) --}}
                        <span
                            wire:loading
                            wire:target="setTab('users')"
                            class="spinner-border spinner-border-sm">
                        </span>
                    </button>

                    <!--Property List-->
                    <button
                        type="button"
                        wire:click="setTab('properties')"
                        wire:loading.attr="disabled"
                        class="btn btn-sm btn-dark fw-semibold w-100 d-flex justify-content-between align-items-center {{ $active === 'properties' ? 'active' : '' }}">

                        <small><small>Property List</small></small>


                        {{-- Icon (normal state) --}}
                        <span
                            wire:loading.remove
                            wire:target="setTab('properties')">
                            0
                        </span>

                        {{-- Spinner (loading state) --}}
                        <span
                            wire:loading
                            wire:target="setTab('properties')"
                            class="spinner-border spinner-border-sm">
                        </span>
                    </button>

                     <!--Messages-->
                    <button
                        type="button"
                        wire:click="setTab('messages')"
                        wire:loading.attr="disabled"
                        class="btn btn-sm btn-dark fw-semibold w-100 d-flex justify-content-between align-items-center {{ $active === 'messages' ? 'active' : '' }}">

                        <small><small>Messages</small></small>


                        {{-- Icon (normal state) --}}
                        <span
                            wire:loading.remove
                            wire:target="setTab('messages')">
                            0
                        </span>

                        {{-- Spinner (loading state) --}}
                        <span
                            wire:loading
                            wire:target="setTab('messages')"
                            class="spinner-border spinner-border-sm">
                        </span>
                    </button>

                </div>

                <div class="mt-auto">
                    <div class="collapse" id="collapseExample">
                        <x-buttons.small-button class="fw-semibold w-100">
                            <small>Settings</small>
                        </x-buttons.small-button>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-buttons.small-button
                                type="submit"
                                class="w-100 fw-semibold mt-1">
                                <small>Log Out</small>
                            </x-buttons.small-button>
                        </form>

                    </div>
                    <p class="mt-2">
                        <button
                            class="btn btn-sm btn-outline-dark shadow-sm py-2 w-100"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseExample"
                            aria-expanded="false"
                            aria-controls="collapseExample">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <div class="d-flex flex-column lh-1 text-start">
                                    <small class="fw-semibold">{{ Auth::user()->firstName }}</small>
                                    <small class="text-secondary">{{ Auth::user()->role }}</small>
                                </div>

                                <i class="bi bi-gear-fill ms-2"></i>
                            </div>
                        </button>
                    </p>
                </div>
            </nav>
        </div>

        <div class="col-10">
            <div class="flex-grow-1 p-4">

                @if ($active === 'environment')
                <livewire:admin.environment-status />

                @elseif ($active === 'host')
                <livewire:admin.host-request />

                @elseif ($active === 'users')
                <livewire:admin.users />

                @elseif ($active === 'properties')
                <livewire:admin.properties />

                @elseif ($active === 'messages')
                <livewire:admin.messages />
                @endif

            </div>
        </div>
    </div>
</div>