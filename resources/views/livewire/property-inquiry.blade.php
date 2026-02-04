<div class="overflow-hidden">
    <div class="vh-100 overflow-auto">
            <form wire:submit.prevent="submitInquiry">
                <div class="container" style="margin-top: 7%;">
                    <div class="row">

                        <div class="col-6">
                            <div class="d-flex align-items-start">
                                @if($property->images && count($property->images) > 0)
                                <img src="{{ asset('storage/' . $property->images[0]) }}"
                                    class="rounded-3 me-2"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                                @endif
                                <div class="">
                                    <p class="fw-medium fs-5 mb-0">{{ $property->propertyName }} Inquire</p>
                                    <p class="mt-0"><small>{{ $property->address }}</small></p>
                                    <p><small>₱{{ number_format($property->propertyCost, 2) }} monthly</small></p>
                                </div>
                            </div>

                            <div class="mt-2">
                                <x-floating-labels.input
                                    type="datetime-local"
                                    id="dateTime"
                                    label="Request your schedule of visit"
                                    wire:model="preferredVisitDate"
                                    class="form-control form-control-lg @error('preferredVisitDate') is-invalid @enderror"
                                    min="{{ now()->addDay()->format('Y-m-d\TH:i') }}"
                                    required />
                            </div>

                            <div class="mt-3">
                                <div class="alert alert-info border-0 rounded-3">
                                    <div class="d-flex gap-3">
                                        <div>
                                            <h6 class="fw-semibold mb-2">
                                                <i class="bi bi-clock-history"></i> What happens next?
                                            </h6>
                                            <ol class="mb-0 small ps-3">
                                                <li class="mb-1">Your inquiry will be sent to the host</li>
                                                <li class="mb-1">The host will review your request (usually within 24 hours)</li>
                                                <li class="mb-1">You'll receive a notification when the host responds</li>
                                                <li>If accepted, you can visit the property at the scheduled time</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <button
                                    class="btn btn-sm btn-outline-dark fw-medium"
                                    type="button"
                                    wire:click="cancel"
                                    wire:loading.attr="disabled">
                                    <small>Cancel</small>
                                </button>

                                <button
                                    class="btn btn-sm btn-dark fw-medium"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="submitInquiry">
                                        <small>Send Inquiry Request</small>
                                    </span>
                                    <span wire:loading wire:target="submitInquiry">
                                        <small>Sending<span class="loading-dots"></span></small>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    @if($property->user->profile_image)
                                    <img src="{{ asset('storage/' . $property->user->profile_image) }}"
                                        class="rounded-circle border"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                    @else
                                    <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center border"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                        {{ strtoupper(substr($property->user->firstName, 0, 1)) }}
                                    </div>
                                    @endif
                                </div>
                                <div class="">
                                    <p class="fw-medium fs-5 mb-0">{{ $property->user->firstName }} {{ $property->user->lastName }}</p>
                                    <span class="badge rounded-pill mt-0" style="background-color: #dcfce7; color: #166534; font-size: 11px; font-weight: 600; padding: 6px 12px;">
                                        <i class="fas fa-check-circle me-1" style="font-size: 10px;"></i>
                                        Verified Host
                                    </span>

                                    <p class="mt-3"><small>Property Host</small></p>
                                </div>
                            </div>

                            <div class="mt-2">
                                <x-floating-labels.text-area
                                    id="message"
                                    height="250"
                                    label="Send a message to the host." />
                            </div>

                        </div>

                    </div>
                </div>
            </form>
    
    </div>
    <!-- Toast Notifications -->
    @if(session('success'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <div class="toast show align-items-center text-white bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <div class="toast show align-items-center text-white bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif


    <style>
        .hover-opacity:hover {
            opacity: 0.7;
            transition: opacity 0.2s;
        }
    </style>

    <script>
        // Auto-hide toasts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 5000);
            });
        });
    </script>
</div>