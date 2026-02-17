<!-- Contact Card -->
<div class="col-12 mx-auto">
    <div class="contact-card p-4 p-md-4 rounded-3 border shadow">

        <div class="row g-4 align-items-center">
            <!-- Host Profile -->
            <div class="col-12 col-md-12 text-center">
                <div class="mb-3 position-relative d-inline-block">
                    @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}"
                        alt="{{ $user->first_name }} {{ $user->last_name }}"
                        class="rounded-circle"
                        style="width: 130px; height: 130px; object-fit: cover;  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                    @else
                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                        style="width: 130px; height: 130px; background: #000000; border: 4px solid #ffffff; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                        @php
                        $firstInitial = strtoupper(substr($user->firstName ?? '', 0, 1));
                        $lastInitial = strtoupper(substr($user->lastName ?? '', 0, 1));
                        $initials = trim($firstInitial . $lastInitial);
                        if (empty($initials)) {
                        $initials = strtoupper(substr($user->name ?? $user->email ?? 'U', 0, 1));
                        }
                        @endphp
                        <span class="fs-2 text-light fw-medium">
                            {{ $initials }}
                        </span>
                    </div>
                    @endif
                    
                    <!-- Online Status Indicator -->
                    @if($user->isOnline())
                    <span class="position-absolute" style="bottom: 0; right: 0; width: 20px; height: 20px; background-color: #28a745; border: 3px solid white; border-radius: 50%; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);" title="Online"></span>
                    @else
                    <span class="position-absolute" style="bottom: 0; right: 0; width: 20px; height: 20px; background-color: #6c757d; border: 3px solid white; border-radius: 50%; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);" title="Offline"></span>
                    @endif

                </div>
                <h5 class="mb-1 fw-medium fs-5">
                    {{ $user->firstName }} {{ $user->lastName }}
                </h5>
                <div class="">
                    @if($user->role === 'host')
                    <span class="badge rounded-pill" style="background-color: #dcfce7; color: #166534; font-size: 11px; font-weight: 600; padding: 6px 12px;">
                        <i class="fas fa-check-circle me-1" style="font-size: 10px;"></i>
                        Verified Host
                    </span>
                    @else
                    <span class="badge rounded-pill" style="background-color: #e7f3ff; color: #0c5aa0; font-size: 11px; font-weight: 600; padding: 6px 12px;">
                        <i class="fas fa-user me-1" style="font-size: 10px;"></i>
                        Tenant
                    </span>
                    @endif
                </div>
            </div>

            @if($showActions ?? true)
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
                        <a href="{{ route('verified-host-info', $user->id) }}"
                            wire:navigate
                            type="button"
                            class="btn btn-sm btn-outline-dark w-100">
                            <span class="fw-semibold">
                                <small>profile</small>
                            </span>
                        </a>
                    </div>

                    @if($showInquire ?? false)
                    <div class="col-12 mt-2">
                        <a href="{{route('tenant.inquiry.create', $property)}}"
                            type="button"
                            class="btn btn-sm btn-dark w-100">
                            <span class="fw-semibold">
                                <small>Inquire</small>
                            </span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
