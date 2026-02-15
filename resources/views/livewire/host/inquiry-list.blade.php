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
            <ul class="nav nav-pills mb-4 gap-2">
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
                    <button class="nav-link {{ $filter === 'accepted' ? 'active' : '' }}"
                        wire:click="$set('filter', 'accepted')">
                        <small>Accepted</small>
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
            <div class="card mb-3 {{ !$inquiry->read_by_host ? 'border-primary' : '' }} shadow-sm border-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            @if(!empty($inquiry->property->images))
                            <img src="{{ asset('storage/' . $inquiry->property->images[0]) }}"
                                class="w-100 rounded"
                                style="height: 100px; object-fit: cover;"
                                alt="{{ $inquiry->property->propertyName }}">
                            @endif
                        </div>
                        <div class="col-md-7">
                            <div class="d-flex align-items-center mb-2">
                                <h6 class="mb-0 me-2">{{ $inquiry->subject }}</h6>
                                @if(!$inquiry->read_by_host)
                                <span class="badge bg-primary">New</span>
                                @endif
                                <span class="badge bg-{{ 
                                    $inquiry->status === 'pending' ? 'warning' : 
                                    ($inquiry->status === 'replied' ? 'info' : 
                                    ($inquiry->status === 'accepted' ? 'success' : 
                                    ($inquiry->status === 'rejected' ? 'danger' : 'secondary'))) 
                                }} ms-2">
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
                            <p class="text-muted mb-0">
                                <small>
                                    <i class="bi bi-geo-alt"></i> {{ $inquiry->property->address }}
                                </small>
                            </p>
                            
                            {{-- Last message preview --}}
                            @if($inquiry->lastMessage())
                                <p class="mb-0 mt-2">
                                    <small class="text-muted fst-italic">
                                        "{{ Str::limit($inquiry->lastMessage()->message, 80) }}"
                                    </small>
                                </p>
                            @endif
                        </div>
                        <div class="col-md-3 text-end">
                            <p class="text-muted mb-2">
                                <small>{{ $inquiry->created_at->diffForHumans() }}</small>
                            </p>
                            
                            {{-- Visit status badge --}}
                            @if($inquiry->visit)
                                <div class="mb-2">
                                    @if($inquiry->visit->status === 'pending')
                                        <span class="badge bg-warning text-dark">
                                            <small>📅 Visit Pending</small>
                                        </span>
                                    @elseif($inquiry->visit->status === 'confirmed')
                                        <span class="badge bg-success">
                                            <small>✅ Visit Confirmed</small>
                                        </span>
                                    @elseif($inquiry->visit->status === 'completed')
                                        <span class="badge bg-info">
                                            <small>✅ Visit Done</small>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            
                            <a href="{{ route('host.inquiry.chat', $inquiry) }}"
                                class="btn btn-sm btn-dark"
                                wire:navigate>
                                <small>Open Chat</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-info">
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="mt-3 mb-0">No inquiries found.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
    
    <style>
        .nav-pills .nav-link {
            background-color: #fff;
            color: #000;
            transition: 0.3s;
        }

        .nav-pills .nav-link:hover {
            background-color: #000;
            color: #fff;
        }

        .nav-pills .nav-link.active {
            background-color: #000;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }
    </style>
</div>