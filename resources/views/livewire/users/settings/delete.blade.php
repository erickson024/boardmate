<div>
    <form wire:submit.prevent="confirmDelete">
        <div class="row">
            <div class="col-12 mb-3">
                <h6 class="mb-0 text-danger">Delete Account</h6>
                <small class="mt-0">Once your account is deleted, all of its resources and data will be permanently removed. This action cannot be undone.</small>
            </div>

            <div class="col-lg-7">
                <x-floating-labels.input
                    type="password"
                    id="password"
                    label="Enter your password"
                    wire:model="password"
                    wire:loading.attr="disabled"
                    wire:target="confirmDelete"
                    required />
            </div>

            <div class="col-12 d-flex align-items-center gap-2 mt-3 mb-3">
                <x-buttons.small-button
                    type="submit"
                    action="confirmDelete"
                    class="btn-danger w-25 fw-semibold"
                    wire:loading.attr="disabled"
                    wire:target="confirmDelete">
                    <span wire:loading.remove wire:target="confirmDelete">Delete Account</span>
                    <span wire:loading wire:target="confirmDelete">
                        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                        Verifying...
                    </span>
                </x-buttons.small-button>
            </div>
        </div>
    </form>

    <!-- Confirmation Modal -->
    @if($showConfirmModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h6 class="modal-title text-danger"><i class="bi bi-exclamation-triangle-fill"></i> Confirm Account Deletion</h6>
                    <button type="button" class="btn-close" wire:click="cancelDelete"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3 fs-6">Are you absolutely sure you want to delete your account?</p>
                    <div class="alert alert-danger mb-0 fs-6">
                        <strong>Warning:</strong> This action is permanent and cannot be undone. All your data will be lost forever.
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-sm btn-secondary fw-semibold" wire:click="cancelDelete">
                        <small>Cancel</small>
                    </button>
                    <button
                        type="button"
                        class="btn btn-sm btn-danger fw-semibold"
                        wire:click="deleteAccount"
                        wire:loading.attr="disabled"
                        wire:target="deleteAccount">
                        <small>
                            <span wire:loading.remove wire:target="deleteAccount">Yes, Delete My Account</span>
                            <span wire:loading wire:target="deleteAccount">
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Deleting...
                            </span>
                        </small>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>