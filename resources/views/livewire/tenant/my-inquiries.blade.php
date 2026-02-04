<div class="overflow-hidden">
    <div class="vh-100 overflow-auto">

        <div class="container">
            <div class="row mt-5">
                <div class="col-12">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <p class="fw-medium fs-5 mb-0 mt-3">
                                <i class="bi bi-envelope-check"></i> My Inquiries
                            </p>
                            <p class="text-muted mb-0 mt-0"><small>Track all your property visit requests</small></p>
                        </div>
                        <a href="{{ route('home') }}" class="btn btn-sm btn-dark">
                            <small><i class="bi bi-search"></i> Search Properties</small>
                        </a>
                    </div>

                    <!-- Filters & Stats -->
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-4 mb-3 mb-md-0">
                                    <label class="form-label fw-medium fs-6 mb-2">Filter by Status</label>
                                    <select wire:model.live="statusFilter" class="form-select shadow-none border-dark filter-status">
                                        <option value="all">All Inquiries</option>
                                        <option value="pending">Pending</option>
                                        <option value="accepted">Accepted</option>
                                        <option value="declined">Declined</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label fw-medium fs-6 mb-2 d-block">Quick Stats</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <div class="badge bg-warning text-dark px-3 py-2">
                                            <i class="bi bi-clock"></i> Pending: {{ $counts['pending'] ?? 0 }}
                                        </div>
                                        <div class="badge bg-success px-3 py-2">
                                            <i class="bi bi-check-circle"></i> Accepted: {{ $counts['accepted'] ?? 0 }}
                                        </div>
                                        <div class="badge bg-danger px-3 py-2">
                                            <i class="bi bi-x-circle"></i> Declined: {{ $counts['declined'] ?? 0 }}
                                        </div>
                                        <div class="badge bg-secondary px-3 py-2">
                                            <i class="bi bi-dash-circle"></i> Cancelled: {{ $counts['cancelled'] ?? 0 }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inquiries List -->
                    @if($inquiries->count() > 0)
                    <div class="row g-4">
                        @foreach($inquiries as $inquiry)
                        <div class="col-12">
                            <div class="card border-0 shadow-sm rounded-4 hover-card">
                                <div class="card-body p-3">
                                    <div class="row">

                                        <!-- Property Image -->
                                        <div class="col-md-3">
                                            @if($inquiry->property && $inquiry->property->images && count($inquiry->property->images) > 0)
                                            <img src="{{ asset('storage/' . $inquiry->property->images[0]) }}"
                                                class="w-100 rounded-3"
                                                style="height: 200px; object-fit: cover;"
                                                alt="{{ $inquiry->property->propertyName }}">
                                            @else
                                            <div class="w-100 bg-light rounded-3 d-flex align-items-center justify-content-center"
                                                style="height: 200px;">
                                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Property Details -->
                                        <div class="col-md-6 mt-3 mt-md-0">
                                            @if($inquiry->property)
                                            <div class="mb-3">
                                                <h5 class="fw-medium mb-1">{{ $inquiry->property->propertyName }}</h5>
                                                <p class="text-muted small mb-2">
                                                   {{ $inquiry->property->address }}
                                                </p>
                                                <p class="fw-medium text-dark mb-0">
                                                    ₱{{ number_format($inquiry->property->propertyCost, 2) }} monthly
                                                </p>
                                            </div>

                                            <!-- Host Info -->
                                            <div class="p-3 bg-light rounded-3 mb-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    @if($inquiry->host->profile_image)
                                                    <img src="{{ asset('storage/' . $inquiry->host->profile_image) }}"
                                                        class="rounded-circle"
                                                        style="width: 35px; height: 35px; object-fit: cover;">
                                                    @else
                                                    <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center"
                                                        style="width: 35px; height: 35px; font-size: 0.9rem;">
                                                        {{ strtoupper(substr($inquiry->host->firstName, 0, 1)) }}
                                                    </div>
                                                    @endif
                                                    <div class="d-flex  flex-column">
                                                        <span class="fw-semibold small">
                                                            {{ $inquiry->host->firstName }} {{ $inquiry->host->lastName }}
                                                        </span>
                                                        <span class="fw-medium" style="font-size: 0.9rem;"><small>Property Host</small></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            <!-- Visit Date -->
                                            @if($inquiry->preferred_visit_date)
                                            <div class="alert alert-info border-0 mb-2 py-2">
                                                <small>
                                                    <i class="bi bi-calendar-event"></i>
                                                    <span class="fw-medium">Request Date Visit:</span>
                                                    {{ $inquiry->preferred_visit_date->format('F d, Y') }} at
                                                    {{ $inquiry->preferred_visit_date->format('h:i A') }}
                                                </small>
                                            </div>
                                            @endif

                                            <!-- Message Preview -->
                                            @if($inquiry->message)
                                            <div class="mt-2">
                                                <p class="small text-muted mb-1">
                                                    <i class="bi bi-chat-dots"></i> Your Message:
                                                </p>
                                                <p class="small mb-0 text-muted fst-italic">
                                                    "{{ Str::limit($inquiry->message, 120) }}"
                                                </p>
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Status & Actions -->
                                        <div class="col-md-3 mt-3 mt-md-0 d-flex flex-column mb-2 justify-content-between">
                                            <div>
                                                <!-- Status Badge -->
                                                <div>
                                                    @if($inquiry->status === 'pending')
                                                    <span class="badge bg-warning text-dark w-100 py-2 fw-medium fs-6">
                                                       <small><i class="bi bi-clock-history"></i> Pending</small> 
                                                    </span>
                                                    @elseif($inquiry->status === 'accepted')
                                                    <span class="badge bg-success w-100 py-2 fw-medium fs-6">
                                                       <small><i class="bi bi-check-circle-fill"></i> Accepted</small> 
                                                    </span>
                                                    @elseif($inquiry->status === 'declined')
                                                    <span class="badge bg-danger w-100 py-2 fw-medium fs-6">
                                                       <small><i class="bi bi-x-circle-fill"></i> Declined</small> 
                                                    </span>
                                                    @else
                                                    <span class="badge bg-secondary w-100 py-2 fw-medium fs-6">
                                                       <small><i class="bi bi-dash-circle-fill"></i> Cancelled</small>
                                                    </span>
                                                    @endif
                                                </div>

                                                <p class="small text-muted mb-2">
                                                    <i class="bi bi-clock"></i> Sent {{ $inquiry->created_at->diffForHumans() }}
                                                </p>

                                                @if($inquiry->status === 'accepted')
                                                <div class="alert alert-success border-0 py-2 px-3 small mb-0">
                                                    <i class="bi bi-check2"></i> Host confirmed your visit!
                                                </div>
                                                @endif
                                            </div>

                                            <!-- Actions -->
                                            <div class="">
                                                @if($inquiry->property)
                                                <a href="{{ route('property.details', $inquiry->property->id) }}"
                                                    class="btn btn-sm btn-outline-dark fw-medium btn-sm w-100 mb-2">
                                                    <small><i class="bi bi-eye"></i> View Property</small>
                                                </a>
                                                @endif

                                                @if($inquiry->status === 'pending')
                                                <button
                                                    wire:click="cancelInquiry({{ $inquiry->id }})"
                                                    class="btn btn-sm btn-outline-danger btn-sm w-100 fw-medium"
                                                    wire:confirm="Are you sure you want to cancel this inquiry?">
                                                    <small><i class="bi bi-x"></i> Cancel Request</small>
                                                </button>
                                                @endif

                                                @if(in_array($inquiry->status, ['declined', 'cancelled']))
                                                <button
                                                    wire:click="deleteInquiry({{ $inquiry->id }})"
                                                    class="btn btn-sm btn-dark btn-sm w-100"
                                                    wire:confirm="Are you sure you want to delete this inquiry?">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $inquiries->links() }}
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="card border-0 shadow-sm rounded-4 mb-3">
                        <div class="card-body p-5 text-center">
                            <div class="mb-1">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                            </div>
                            <p class="fw-medium fs-5 mb-3">
                                @if($statusFilter === 'all')
                                No Inquiries Yet
                                @else
                                No {{ ucfirst($statusFilter) }} Inquiries
                                @endif
                            </p>
                            <p class="text-muted mb-4">
                                <small>
                                    @if($statusFilter === 'all')
                                    You haven't sent any property visit requests yet.<br>
                                    Start browsing properties and schedule a visit!
                                    @else
                                    You don't have any {{ $statusFilter }} inquiries at the moment.
                                    @endif
                                </small>
                            </p>
                            <a href="{{ route('home') }}" class="btn btn-sm btn-dark">
                                <small><i class="bi bi-search"></i> Search Properties</small>
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <style>
            .hover-card {
                transition: transform 0.2s, box-shadow 0.2s;
            }

            .hover-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            }

            .filter-status {
                font-size: 14px;
                font-weight: 500;
            }
        </style>
    </div>
</div>

<script>
    // Auto-hide toasts
    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('.toast');
        toasts.forEach(toast => {
            setTimeout(() => {
                toast.classList.remove('show');
            }, 5000);
        });
    });
</script>