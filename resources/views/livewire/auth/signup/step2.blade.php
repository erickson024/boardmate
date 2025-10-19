<div>
    <span class="fs-6 fw-medium">Set-Up your password.</span>
    <p><small>Please make your password strong by adding special characters.</small></p>

    <div class="row gap-3 mb-3 mt-3">
        <div class="col-12">
            <div class="form-floating">
                <input
                    type="password"
                    wire:model.live="password"
                    id="password"
                    name="password"
                    class="form-control border-1 shadow-sm"
                    placeholder="firstname"
                    required>
                <label for="password" class="fw-medium"><small>password</small></label>

                <button
                    type="button"
                    class="btn btn-sm btn-link position-absolute top-50 end-0 translate-middle-y me-2 text-secondary"
                    onclick="togglePassword('password', this)"
                    tabindex="-1">
                    <i class="bi bi-eye"></i>
                </button>

                <div class="progress rounded mt-2" style="height: 3px;">
                    <div class="progress-bar 
                                    @if($strengthScore < 2) bg-danger 
                                    @elseif($strengthScore < 4) bg-warning 
                                    @else bg-success 
                                    @endif"
                        role="progressbar"
                        style="width: {{ ($strengthScore/5) * 100 }}%">
                    </div>
                </div>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="col-12">
            <div class="form-floating">
                <input
                    type="password"
                    wire:model="confirmPassword"
                    id="confirmPassword"
                    name="confirmPassword"
                    class="form-control border-1 shadow-sm"
                    placeholder="firstname"
                    required>
                <label for="password" class="fw-medium"><small>confirm password</small></label>

                <button
                    type="button"
                    class="btn btn-sm btn-link position-absolute top-50 end-0 translate-middle-y me-2 text-secondary"
                    onclick="togglePassword('confirmPassword', this)"
                    tabindex="-1">
                    <i class="bi bi-eye"></i>
                </button>

                @error('confirmPassword') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
    </div>
    <form wire:submit.prevent="submit" class="d-flex justify-content-between">
        <button type="button" class="btn btn-sm btn-outline-dark" wire:click="back">
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

    <style>
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
    </style>

</div>