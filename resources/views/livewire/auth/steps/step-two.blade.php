<div>
    <div class="row">
        <p class="text-dark fs-6 fw-semibold mb-0">Step 2: Set up your password.</p>
        <small class="mt-0">Use a strong password with a mix of letters, numbers, and symbols. Avoid common words and patterns.</small>

        <div class="col-12 col-md-8 col-lg-8 mt-2">
            <div class="form-floating ">

                <input
                    type="password"
                    class="form-control border-dark text-dark shadow-none"
                    placeholder="Enter your password"
                    wire:model="password" />
                <label for="floatingInput" class="text-dark">Password</label>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="col-12 col-md-8 col-lg-8 mt-2">

            <div class="form-floating ">
                <input
                    type="password"
                    class="form-control border-dark text-dark shadow-none"
                    placeholder="Enter your password"
                    wire:model="password_confirmation" />

                <label for="floatingInput" class="text-dark">Confirm Password</label>
                @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

    </div>
</div>