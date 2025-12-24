<div>
    <p class="fs-6 fw-semibold">Provide the policies that tenants need to follow.</p>

    <form wire:submit.prevent="submit">
        <div class="row g-3">
            <div class="col-12">
                <div class="form-floating">
                    <textarea
                        class="form-control border-1 shadow-sm font-property"
                        wire:model="terms"
                        placeholder="Leave a comment here"
                        id="floatingTextarea2"
                        style="height: 100px"></textarea>
                    <label for="floatingTextarea2" class="fw-semibold"><small>Terms and Condition</small></label>
                </div>
                @error('terms') <div class="text-danger"><small>{{ $message }}</small></div> @enderror
            </div>

            <div class="col-12">
                <div class="form-floating">
                    <textarea
                        class="form-control border-1 shadow-sm font-property"
                        wire:model="payment"
                        placeholder="Leave a comment here"
                        id="floatingTextarea2"
                        style="height: 100px"></textarea>
                    <label for="floatingTextarea2" class="fw-semibold"><small>Payment Terms</small></label>
                </div>
                @error('payment') <div class="text-danger"><small>{{ $message }}</small></div> @enderror
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input
                        class="form-check-input shadow-none border-dark"
                        type="checkbox"
                        wire:model="agree"
                        id="agree"
                        required>
                    <label class="form-check-label fw-medium" for="agree">
                        <small> I confirm that the provided rules and policies are accurate and I agree to the terms.</small>
                    </label>
                </div>
                @error('agree') <div class="text-danger"><small>{{ $message }}</small></div> @enderror
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-between">
            <button type="button" class="btn btn-sm btn-outline-dark" wire:click="back">
                <span class="fw-semibold small">Back</span>
                <span wire:loading wire:target="back">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
            </button>

            <button type="submit" class="btn btn-sm btn-dark">
                <span class="fw-semibold small">Upload Property</span>
                <span wire:loading wire:target="submit">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
            </button>
        </div>
    </form>

    <style>
        .form-check-input:checked {
            background-color: #000 !important;
            border-color: #000 !important;
        }
    </style>
</div>