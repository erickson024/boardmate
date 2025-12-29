<div class="">
    <p>this is step2</p>

    <div class="d-flex justify-content-between mb-5">
        <button class="btn btn-sm btn-outline-dark fw-semibold" wire:click="back">
            <span>Back</span>
            <span wire:loading wire:target="back">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </span>
        </button>
    </div>
</div>