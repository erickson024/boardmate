<div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="row justify-content-center w-100">
        <div class="col-12 col-md-6 mb-3">
            <div class="row align-items-center">
                <div class="col-md-3">
                    @if(!empty($property->images))
                    <img src="{{ asset('storage/' . $property->images[0]) }}"
                        class="w-100 rounded"
                        style="height: 80px; object-fit: cover;"
                        alt="{{ $property->propertyName }}">
                    @endif
                </div>

                <div class="col-md-9">
                    <h6 class="mb-1">{{ $property->propertyName }}</h6>
                    <p class="text-muted mb-1 text-truncate" style="max-width: 100%;">
                        <small>{{ $property->address }}</small>
                    </p>
                    @if($property->propertyCost)
                    <p class="fw-medium mb-0"><small>₱{{ number_format($property->propertyCost, 0) }} monthly</small></p>
                    @endif
                </div>

                <div class="col-12 mt-3">
                    @if($existingInquiry)
                        {{-- Already has inquiry --}}
                        <div class="border border-dark p-4 rounded">
                            <h6 class="alert-heading"><i class="bi bi-info-circle"></i> You already have an inquiry for this property</h6>
                            <p class="mb-2"><span class="badge bg-{{ $existingInquiry->status === 'pending' ? 'warning' : ($existingInquiry->status === 'replied' ? 'success' : 'secondary') }}">{{ ucfirst($existingInquiry->status) }}</span></small></p>
                            <p class="mb-3"><small>{{ $existingInquiry->created_at->diffForHumans() }}</small></p>
                            <hr>
                            <div class="d-flex gap-2">
                                <a href="{{ route('tenant.inquiries') }}" 
                                   class="btn btn-sm btn-dark"
                                   wire:navigate>
                                    <small>View My Inquiries</small>
                                </a>
                                <a href="{{ route('property.details', $property) }}" 
                                   class="btn btn-sm btn-outline-dark"
                                   wire:navigate>
                                    <small>Back to Property</small>
                                </a>
                            </div>
                        </div>
                    @else
                        {{-- Can send inquiry --}}
                        <form wire:submit.prevent="submit">
                            {{-- Subject --}}
                            <div class="mb-3">
                                <x-floating-labels.input
                                    label="Subject"
                                    id="subject"
                                    wire:model="subject"
                                    type="text"
                                    disabled />
                            </div>

                            {{-- Message --}}
                            <div class="mb-3">
                                <x-floating-labels.text-area
                                    label="Message the host"
                                    id="message"
                                    wire:model="message"
                                    type="text" />
                            </div>

                            {{-- Buttons --}}
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <a href="{{ route('property.details', $property) }}"
                                    class="btn btn-sm btn-outline-dark fw-medium"
                                    wire:navigate>
                                    <small>Cancel</small>
                                </a>
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-dark"
                                    wire:loading.attr="disabled">
                                    <small>
                                        <span wire:loading.remove>
                                            <i class="bi bi-send me-1"></i> Send Inquiry
                                        </span>
                                        <span wire:loading>
                                            <span class="spinner-border spinner-border-sm me-1"></span>
                                            Sending...
                                        </span>
                                    </small>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-6 px-5 d-flex justify-content-center">
            {{-- Host card stays the same --}}
            <div class="contact-card d-flex align-items-center justify-content-center p-4 p-md-4 h-100 w-75 rounded-3 border shadow-sm">
                <div class="row g-4 align-items-center">
                    <div class="col-12 text-center">
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
                        <div class="mb-3">
                            <span class="badge rounded-pill" style="background-color: #dcfce7; color: #166534; font-size: 11px; font-weight: 600; padding: 6px 12px;">
                                <i class="fas fa-check-circle me-1" style="font-size: 10px;"></i>
                                Property Host
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
