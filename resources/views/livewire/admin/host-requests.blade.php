<div>
    <div class="mb-4">
        <h3 class="fw-medium">Pending Host Requests</h3>
    </div>

    @if($requests->isEmpty())
    <div class="shadow-sm rounded p-3">
        <p class="text-muted">No pending requests.</p>
    </div>

    @else
    <div>
        @foreach($requests as $req)
        <div class="d-flex justify-content-between align-items-center py-3 px-3 mb-2 border shadow-sm rounded">
            <!-- Profile image and user info -->
            <div class="d-flex align-items-center">
                <x-profile-image
                    :firstName="$req->user->firstName ?? ''"
                    :lastName="$req->user->lastName ?? ''"
                    :image="$req->user->profileImage ?? null"
                    :size="35" />

                <div class="ms-2 lh-1">
                    <div class="fw-semibold ">
                        {{ $req->user->firstName ?? '' }} {{ $req->user->lastName ?? '' }}
                    </div>
                    <div class="text-muted small">
                        {{ $req->user->email ?? '' }}
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="d-flex gap-1">
                <button wire:click="approve('{{ $req->id }}')"
                    wire:loading.attr="disabled"
                    class="btn btn-sm btn-dark fw-semibold">
                    <small>Approve</small>
                </button>
                <button wire:click="deny('{{ $req->id }}')"
                    wire:loading.attr="disabled"
                    class="btn btn-sm btn-danger fw-semibold">
                    <small>Deny</small>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>