<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-0">Tenant Inquiries</h4>
                    @if($unreadCount > 0)
                    <span class="badge bg-danger mt-1">{{ $unreadCount }} new</span>
                    @endif
                </div>
            </div>

            {{-- Filter Tabs --}}
            <ul class="nav nav-pills mb-4">
                <li class="nav-item">
                    <button class="nav-link {{ $filter === 'all' ? 'active' : '' }}"
                        wire:click="$set('filter', 'all')">
                        <small>All</small>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link {{ $filter === 'pending' ? 'active' : '' }}"
                        wire:click="$set('filter', 'pending')">
                        <small>Pending</small>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link {{ $filter === 'replied' ? 'active' : '' }}"
                        wire:click="$set('filter', 'replied')">
                        <small>Replied</small>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link {{ $filter === 'closed' ? 'active' : '' }}"
                        wire:click="$set('filter', 'closed')">
                        <small>Closed</small>
                    </button>
                </li>
            </ul>

            {{-- Inquiry List --}}
            @forelse($inquiries as $inquiry)
            <div class="card mb-3 {{ !$inquiry->read_by_host ? 'border-primary' : '' }} border border-0 shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            @if(!empty($inquiry->property->images))
                            <img src="{{ asset('storage/' . $inquiry->property->images[0]) }}"
                                class="w-100 rounded"
                                style="height: 80px; object-fit: cover;"
                                alt="{{ $inquiry->property->propertyName }}">
                            @endif
                        </div>
                        <div class="col-md-7">
                            <div class="d-flex align-items-center mb-2">
                                <h6 class="mb-0 me-2">{{ $inquiry->subject }}</h6>
                                @if(!$inquiry->read_by_host)
                                <span class="badge bg-primary">New</span>
                                @endif
                                <span class="badge bg-{{ $inquiry->status === 'pending' ? 'warning' : ($inquiry->status === 'replied' ? 'success' : 'secondary') }} ms-2">
                                    {{ ucfirst($inquiry->status) }}
                                </span>
                            </div>
                            <p class="text-muted mb-1">
                                <small>
                                    <i class="bi bi-person"></i> {{ $inquiry->tenant->firstName }} {{ $inquiry->tenant->lastName }}
                                </small>
                            </p>
                            <p class="text-muted mb-1">
                                <small>
                                    <i class="bi bi-house"></i> {{ $inquiry->property->propertyName }}
                                </small>
                            </p>
                            <p class="mb-0"><small>{{ Str::limit($inquiry->message, 100) }}</small></p>
                        </div>
                        <div class="col-md-3 text-end">
                            <p class="text-muted mb-2">
                                <small>{{ $inquiry->created_at->diffForHumans() }}</small>
                            </p>

                            
                            <a href="{{ route('host.inquiry.chat', $inquiry) }}"
                                class="btn btn-sm btn-dark"
                                wire:navigate>
                                <small>Message</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-info">
                <small>No inquiries found.</small>
            </div>
            @endforelse
        </div>
    </div>
</div>
