<div>
    <span class="fs-6 fw-medium">Your Email and Terms and Condition.</span>

    <form wire:submit.prevent="submit" class="mt-4 d-flex justify-content-between">
        <button type="button" class="btn btn-sm btn-outline-dark" wire:click="back">
            <span>Back</span>
            <span wire:loading wire:target="back">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </span>
        </button>
        <button type="submit" class="btn btn-sm btn-dark" wire:click="submit">
            <span>Create Account</span>
            <span wire:loading wire:target="submit">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </span>
        </button>
    </form>
</div>