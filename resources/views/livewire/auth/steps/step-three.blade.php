<div class="row">
    <p class="text-dark mb-0 fs-6 fw-semibold">Step 3: Email and Privacy Policy.</p>
    <small class="mt-0 mb-2">We respect your privacy. Verify your email and accept the Terms and Privacy Policy to secure your account</small>

    <div class="col-12 col-md-8 col-lg-8">

        <div class="form-floating">
            <input type="email"
                class="form-control border-dark text-dark shadow-none"
                id="floatingEmail"
                placeholder="Enter your email"
                value="{{ old('email') }}"
                wire:model="email" />
            <label for="floatingEmail" class="text-dark">Email Address</label>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-check mt-3">
            <input
                class="form-check-input shadow-none border-dark"
                name="terms"
                type="checkbox"
                value="accepted "
                wire:model="terms"
                d="flexCheckDefault">
            <label class="form-check-label " for="flexCheckDefault">
                I have read and accept the <a href=""
                    class="link-underline-dark link-underline-opacity-0   link-underline-opacity-100-hover text-dark fw-medium">
                    Privacy Policy</a>
            </label>
            @error('terms')
            <div>
                <small class="text-danger d-block">{{ $message }}</small>
            </div>
            @enderror
        </div>

    </div>
</div>