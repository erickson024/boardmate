<div>
    <span class="fs-6 fw-medium">Your Email and Terms and Condition.</span>
    <small class="d-block">Use a valid email to recieve a verification message with a confirmation link.</small>

    <form wire:submit.prevent="submit" class="mt-3">
        <div class="row mt-3 gap-3">
            <div class="col-12">
                <div class="form-floating">
                    <input
                        type="email"
                        wire:model="email"
                        id="email"
                        name="email"
                        class="form-control border-1 shadow-sm"
                        placeholder="email"
                        required>
                    <label for="email" class="fw-medium"><small>email</small></label>
                     @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input shadow-none" wire:model="terms">
                    <label>
                        <small>I agree to the
                            <a href=""
                                class="link-dark link-offset-2 link-offset-1-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover text-dark fw-medium">terms and conditions</a>.</small>
                    </label>
                </div>
                @error('terms') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="d-flex justify-content-between mt-3">
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
        </div>
    </form>

    <style>
        .form-check-input:checked {
            background-color: #000 !important;
            border-color: #000 !important;
        }
    </style>
</div>