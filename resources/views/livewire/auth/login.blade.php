
<div class="container " style="height: 85vh;">
    <div class="row p-2 gx-3 slide-in-up rounded h-100 ">

        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class=" p-4 border border-dark shadow rounded h-100 " style="background-color: #ffffff;">

                <div class="row">
                    <div class="col-9 col-md-7 col-lg-9">
                        <p class="fw-semibold fs-5 mb-2">Ready to Login Bordmate</p>
                        <p class="small">
                            Dont have any account?
                            <a href="{{route('register')}}" class="link-underline-dark link-underline-opacity-0 link-underline-opacity-100-hover text-dark fw-medium">
                                Register</a>
                        </p>
                    </div>

                    <div class="col-3  col-md-5 col-lg-3 mb-2 d-flex justify-content-end ">
                        <div class="gap-2">
                            <button class="btn btn-sm btn-dark"><i class="bi bi-google"></i></button>
                            <button class="btn btn-sm btn-dark"><i class="bi bi-phone-fill"></i></button>
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


                    <button type="submit" class="btn btn-dark w-100 mt-3" wire:loading.attr="disabled">
                        Login
                        <span wire:loading wire:target="login" class="spinner-border spinner-border-sm me-1"></span>
                    </button>

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

