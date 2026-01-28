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
                    <div class="fw-semibold">
                        {{ $req->user->firstName ?? '' }} {{ $req->user->lastName ?? '' }}
                    </div>
                    <div class="text-muted small">
                        {{ $req->user->email ?? '' }}
                    </div>
                    <div class="text-muted small">
                        <i class="bi bi-clock"></i> Requested {{ $req->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="d-flex gap-1">
                <button 
                    wire:click="approve('{{ $req->id }}')"
                    wire:loading.attr="disabled"
                    wire:target="approve('{{ $req->id }}')"
                    class="btn btn-sm btn-dark fw-semibold">
                    <span wire:loading.remove wire:target="approve('{{ $req->id }}')">
                        <small>Approve</small>
                    </span>
                    <span wire:loading wire:target="approve('{{ $req->id }}')">
                        <span class="spinner-border spinner-border-sm"></span>
                    </span>
                </button>
                <button 
                    wire:click="openDenyModal('{{ $req->id }}')"
                    wire:loading.attr="disabled"
                    class="btn btn-sm btn-danger fw-semibold">
                    <small>Deny</small>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Deny Modal -->
    @if($showDenyModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">Deny Host Request</h5>
                    <button type="button" class="btn-close" wire:click="closeDenyModal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3">
                        <small>Please provide a reason for denying this request. The user will be notified with this reason.</small>
                    </p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Reason for Denial <span class="text-danger">*</span></label>
                        <textarea 
                            wire:model="denyReason" 
                            class="form-control @error('denyReason') is-invalid @enderror" 
                            rows="4" 
                            placeholder="E.g., Incomplete profile information, Does not meet hosting requirements..."></textarea>
                        @error('denyReason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" wire:click="closeDenyModal">
                        Cancel
                    </button>
                    <button 
                        type="button" 
                        class="btn btn-sm btn-danger" 
                        wire:click="confirmDeny"
                        wire:loading.attr="disabled"
                        wire:target="confirmDeny">
                        <span wire:loading.remove wire:target="confirmDeny">
                            Confirm Deny
                        </span>
                        <span wire:loading wire:target="confirmDeny">
                            <span class="spinner-border spinner-border-sm"></span> Processing...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>