<div class="row  vh-100 d-flex align-items-center section property-host">
    <div class="col-12 ">
        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <div class="text-center mb-3">
                    <p class="fw-medium fs-5 mb-0">Get In Touch</p>
                    <div class="text-muted mb-0">
                        <p class="mb-0"><small>Interested in this property?</small></p>
                        <p class="mb-0"><small> Contact the host directly for more information or click Inquire to schedule a visit.</small></p>
                    </div>
                </div>
                <!-- Contact Card -->
                <div class="col-12 col-lg-4 mx-auto">
                    <div class="contact-card p-4 p-md-4 rounded-3 border shadow">

                        <div class="row g-4 align-items-center">
                            <!-- Host Profile -->
                            <div class="col-12 col-md-12 text-center">
                                <div class="mb-3 position-relative d-inline-block">
                                    @if($property->user->profile_image)
                                    <img src="{{ asset('storage/' . $property->user->profile_image) }}"
                                        alt="{{ $property->user->first_name }} {{ $property->user->last_name }}"
                                        class="rounded-circle"
                                        style="width: 130px; height: 130px; object-fit: cover;  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                                    @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 120px; height: 120px; background: #000000; border: 4px solid #ffffff; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                                        @php
                                        $firstInitial = strtoupper(substr($property->user->firstName ?? '', 0, 1));
                                        $lastInitial = strtoupper(substr($property->user->lastName ?? '', 0, 1));
                                        $initials = trim($firstInitial . $lastInitial);
                                        if (empty($initials)) {
                                        $initials = strtoupper(substr($property->user->name ?? $property->user->email ?? 'U', 0, 1));
                                        }
                                        @endphp
                                        <span class="fs-2 text-light fw-medium">
                                            {{ $initials }}
                                        </span>
                                    </div>
                                    @endif

                                </div>
                                <h5 class="mb-1 fw-medium fs-5">
                                    {{ $property->user->firstName }} {{ $property->user->lastName }}
                                </h5>
                                <div class="">
                                    <span class="badge rounded-pill" style="background-color: #dcfce7; color: #166534; font-size: 11px; font-weight: 600; padding: 6px 12px;">
                                        <i class="fas fa-check-circle me-1" style="font-size: 10px;"></i>
                                        Verified Host
                                    </span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row gx-2">
                                    <div class="col-4">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-dark w-100">
                                            <span class="fw-semibold">
                                                <small>connect</small>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-dark w-100">
                                            <span class="fw-semibold">
                                                <small>message</small>
                                            </span>
                                        </button>
                                    </div>

                                    <div class="col-4">
                                        <a href="{{ route('verified-host-info', $host->id) }}"
                                            wire:navigate
                                            type="button"
                                            class="btn btn-sm btn-outline-dark w-100">
                                            <span class="fw-semibold">
                                                <small>profile</small>
                                            </span>
                                        </a>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <a href=""
                                            type="button"
                                            class="btn btn-sm btn-dark w-100">
                                            <span class="fw-semibold">
                                                <small>Inquire</small>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>