<div class="container">
    <div class="row p-2 gx-3 slide-in-up rounded">

        <div class="col-md-6">
            <div class=" p-4 border border-dark shadow rounded" style="height: 465px; background-color: #ffffff;">

                <div class="row">
                    <div class="col-7">
                        <p class="fw-semibold fs-4 mb-2">Welcome back!</p>
                        <p class="small">
                            Dont have any account?
                            <a href="{{route('register')}}" class="link-underline-dark link-underline-opacity-0 link-underline-opacity-100-hover text-dark fw-medium">
                                Register</a>
                        </p>
                    </div>

                    <div class="col-5 d-flex justify-content-end">
                        <div class="gap-2">
                            <button class="btn btn-sm btn-dark"><i class="bi bi-google"></i></button>
                            <button class="btn btn-sm btn-dark"><i class="bi bi-hash"></i></button>
                        </div>
                    </div>
                </div>


                <form wire:submit.prevent="login">
                    <div class="form-floating mb-3">
                        <input type="email"
                            class="form-control border-dark text-dark shadow-none"
                            id="emailInput"
                            placeholder="johndoe@gmail.com"
                            wire:model="email">
                        <label for="emailInput" class="text-dark">email address</label>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-floating">
                        <input type="password"
                            class="form-control border-dark text-dark shadow-none"
                            id="passwordInput"
                            placeholder="@test123"
                            wire:model="password">
                        <label for="passwordInput" class="text-dark">password</label>
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{route('register')}}" class="link-underline-dark link-underline-opacity-0 link-underline-opacity-100-hover text-dark fw-medium">
                            <small>Forget Password?</small>
                        </a>
                    </div>


                    <button type="submit" class="btn btn-dark" wire:loading.attr="disabled">
                        Login
                        <span wire:loading wire:target="login" class="spinner-border spinner-border-sm me-1"></span>
                    </button>

                </form>
            </div>
        </div>

        <div class="col-md-6 ">
            <div class=" h-100 shadow rounded"
            style="background: linear-gradient(135deg, #fff3cd, #ffc107);"
            >
                <img 
                src="{{asset('images/image4.png')}}" 
                class="img-fluid h-100" 
                alt="..." 
                style="object-fit: cover;"
                >
            </div>
        </div>
    </div>
</div>