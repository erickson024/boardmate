<div class="container-fluid vh-100">
    <div class="row h-100">
        <!-- LEFT -->
        <div class="col-12 col-md-6 p-5 d-flex flex-column">

            <div class="mb-3">
                <x-buttons.small-button href="{{ route('home') }}">
                    <i class="bi bi-arrow-left-short"></i>
                    <span class="fw-semibold small">Boardmate Home</span>
                </x-buttons.small-button>
            </div>

            <div class="mb-3">
                <span class="fw-semibold  small">Important Note</span>

                <p class="mb-2 text-muted">
                    <small>
                        To become a verified host, please submit a request to our development team by clicking the request button bellow.
                        Once submitted, we will notify you for the next step via messages or email.
                    </small>
                </p>

                <!-- Background polling -->
                <div wire:poll.5s.keep-alive="checkRequestStatus"></div>
                <!-- ACTION BUTTON -->
                <button
                    wire:click="submitRequest"
                    wire:loading.attr="disabled"
                    wire:target="submitRequest"
                    class="btn btn-sm btn-outline-dark"
                    @if($request && $request->status === 'pending') disabled @endif
                    >
                    <small class="fw-semibold">

                        <span wire:loading wire:target="submitRequest">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Sending
                        </span>

                        <span wire:loading.remove wire:target="submitRequest">
                            @if($request && $request->status === 'pending')
                            Pending Request - wait for the admin response
                            @elseif($request && $request->status === 'approved')
                            Approved
                            @else
                            Send Request
                            @endif
                        </span>

                    </small>
                </button>
            </div>

            <div class="row g-3 mt-auto">
                <span class="small fw-semibold mb-0">Host Eligibility Requirements</span>
                <span class="mt-0 text-muted"><small>Make sure you meet all the requirements below before submitting your request.</small></span>

                <div class="col-6 col-md-4">
                    <div class="p-2 h-100 text-center d-flex flex-column">
                        <div class="mb-1 text-primary fs-2">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <span class="fw-semibold mb-1 small">Complete Profile</span>
                        <span class="text-muted" style="font-size: 12px;">
                            Your account profile must be fully completed and accurate.
                        </span>
                    </div>
                </div>

                <div class="col-6 col-md-4">
                    <div class="p-2 h-100 text-center d-flex flex-column shadow rounded">
                        <div class="mb-1 text-primary fs-2">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <span class="fw-semibold mb-1 small">Professional</span>
                        <span class="text-muted" style="font-size: 12px;">
                            Commit to hosting responsibly and professionally.
                        </span>
                    </div>
                </div>

                <div class="col-6 col-md-4">
                    <div class=" p-2 h-100 text-center d-flex flex-column">
                        <div class="mb-1 text-primary fs-2">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <span class="fw-semibold mb-1 small">Community Rules</span>
                        <span class="text-muted" style="font-size: 12px;">
                            Agree to follow BoardMate’s hosting guidelines and rules.
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-12 col-md-6 d-flex flex-column bg-dark">
            <div class="text-center text-light mt-5 py-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-patch-check-fill mb-4" viewBox="0 0 16 16">
                    <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                </svg>

                <div class="fs-4 fw-semibold">Be a Verified Host</div>
                <div class="fs-6 fw-medium">Join our team</div>
            </div>

            <div class="mt-auto">
                <img
                    src="{{ asset('images/image8.png') }}"
                    class="img-fluid w-100"
                    style="object-fit: cover; max-height: 85vh;"
                    loading="lazy">
            </div>
        </div>

    </div>
</div>