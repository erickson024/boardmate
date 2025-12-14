<div class="container-fluid vh-100">
    <div class="row h-100">
        <div class="col-6 p-5">
            <div class="mb-5">
                <x-buttons.small-button href="{{route('home')}}">
                    <i class="bi bi-arrow-left-short"></i>
                    Boardmate Home
                </x-buttons.small-button>
            </div>
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="fw-bold mb-2">Important Note</h6>
                    <p class="mb-3">
                        <small>
                            To become a verified host, please submit a request to our development team by clicking the button below.
                            Once submitted, we will schedule an interview via zoom to complete the verification process.
                        </small>
                    </p>
                    <button
                        wire:click="submitRequest"
                        wire:loading.attr="disabled"
                        class="btn btn-sm btn-primary"
                        @if($request && $request->status == 'pending') disabled @endif
                        >
                        <small class="fw-semibold">
                            {{-- Show "Sending..." while processing --}}
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                Sending
                            </span>

                            {{-- Normal state --}}
                            <span wire:loading.remove>
                                @if($request && $request->status == 'pending')
                                Pending Request
                                @else
                                Send Request
                                @endif
                            </span>
                        </small>
                    </button>
                </div>
            </div>

        </div>

        <div class="col-6 d-flex flex-column bg-dark">
            <div class="flex-column text-light text-center mt-5 py-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-patch-check-fill mb-4" viewBox="0 0 16 16">
                    <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                </svg>
                <div class="fs-4 fw-semibold text-light ">Be a Verified Host.</div>
                <div class="fs-6 fw-medium text-light ">join our team</div>
                <!-- This empty div pushes the image down -->
                <div class="flex-grow-1"></div>
            </div>

            <div class="mt-auto position-relative">
                <img
                    src="{{ asset('images/image8.png') }}"
                    alt="Sign up hero image"
                    class="img-fluid w-100"
                    style="object-fit: cover; object-position: center; max-height: 85vh; flex-shrink: 0;"
                    loading="lazy" />
            </div>
        </div>
    </div>
</div>