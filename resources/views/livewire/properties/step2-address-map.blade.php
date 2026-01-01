<div class="">
        <form wire:submit.prevent="submit" class="mt-3  d-flex justify-content-between">
            <button type="button" class="btn btn-sm btn-outline-dark fw-semibold" wire:click="back">
                <span>Back</span>
                <span wire:loading wire:target="back">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
            </button>

            <button type="submit" class="btn btn-sm btn-dark">
                <span>Continue</span>
                <span wire:loading wire:target="submit">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
            </button>
        </form>
    </div>
