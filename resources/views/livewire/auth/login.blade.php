
<div class="container " style="height: 85vh;">
    <div class="row p-2 gx-3 slide-in-up rounded h-100 ">

        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class=" p-4 border border-dark shadow rounded h-100 " style="background-color: #ffffff;">

                <div class="row">
                    <div class="col-12">
                        <p class="fw-semibold fs-5 mb-2">Ready to Login Bordmate</p>
                        <p class="small">
                            Dont have any account?
                            <a href="{{route('register')}}" class="link-underline-dark link-underline-opacity-0 link-underline-opacity-100-hover text-dark fw-medium" wire:navigate>
                                Register</a>
                        </p>
                    </div>
                </div>


                <form wire:submit.prevent="login">
                    <div class="form-floating mb-3">
                        <input type="email"
                            class="form-control border-dark text-dark shadow-none"
                            id="emailInput"
                            placeholder="johndoe@gmail.com"
                            wire:model="email"
                            required>
                        <label for="emailInput" class="text-dark"><small>email</small></label>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-floating">
                        <input type="password"
                            class="form-control border-dark text-dark shadow-none"
                            id="passwordInput"
                            placeholder="@test123"
                            wire:model="password"
                            required>
                        <label for="passwordInput" class="text-dark"><small>password</small></label>

                    </div>

                    <div class="">
                        <div class="row mt-1">
                            <div class="col-6 d-flex justify-content-start">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <a href="{{route('register')}}" class="link-underline-dark link-underline-opacity-0 link-underline-opacity-100-hover text-dark fw-medium">
                                    <small>Forget Password?</small>
                                </a>
                            </div>
                        </div>
                    </div>


                  <button 
    type="submit" 
    class="btn btn-dark w-100 mt-3" 
    wire:loading.attr="disabled"
>
    <span wire:loading.remove wire:target="login">
        Login
    </span>
    <span wire:loading wire:target="login">
        <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
        Logging in...
    </span>
</button>

<!-- Divider -->
<div class="d-flex align-items-center mt-5">
    <hr class="flex-grow-1 border-secondary opacity-50">
    <span class="mx-2 text-muted fw-semibold small">OR</span>
    <hr class="flex-grow-1 border-secondary opacity-50">
</div>

<!-- Google Sign-in -->
<div class="text-center">
    <a href="{{ route('google.redirect') }}" class="btn btn-outline-primary w-100">
        <i class="bi bi-google me-2"></i> <small>Sign in with Google</small>
    </a>
</div>


                </form>
            </div>
        </div>

        <div class="col-md-6 col-sm-0 d-none d-lg-block">
            <div class=" h-100  shadow rounded"
                style="background: linear-gradient(135deg, #fff3cd, #ffc107);">
                <img
                    src="{{asset('images/image4.png')}}"
                    class="img-fluid h-100"
                    alt="..."
                    style="object-fit: cover;">
            </div>
        </div>
    </div>


    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
</div>

