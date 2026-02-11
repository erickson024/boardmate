<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">My Inquiries</h4>
            </div>

            {{-- Filter Tabs --}}
            <ul class="nav nav-pills mb-4 gap-2">
                <li class="nav-item">
                    <button class="nav-link  {{ $filter === 'all' ? 'active' : '' }}"
                        wire:click="$set('filter', 'all')">
                        <small>All</small>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link  {{ $filter === 'pending' ? 'active' : '' }}"
                        wire:click="$set('filter', 'pending')">
                        <small>Pending</small>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link  {{ $filter === 'replied' ? 'active' : '' }}"
                        wire:click="$set('filter', 'replied')">
                        <small>Replied</small>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link  {{ $filter === 'closed' ? 'active' : '' }}"
                        wire:click="$set('filter', 'closed')">
                        <small>Closed</small>
                    </button>
                </li>
            </ul>

            {{-- Inquiry List --}}
            @forelse($inquiries as $inquiry)
            <div class="card mb-3">
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
                                <span class="badge bg-{{ $inquiry->status === 'pending' ? 'warning' : ($inquiry->status === 'replied' ? 'success' : 'secondary') }}">
                                    {{ ucfirst($inquiry->status) }}
                                </span>
                            </div>
                            <p class="text-muted mb-1">
                                <small>
                                    <i class="bi bi-house"></i> {{ $inquiry->property->propertyName }}
                                </small>
                            </p>
                            <p class="text-muted mb-1">
                                <small>
                                    <i class="bi bi-person"></i> Host: {{ $inquiry->host->firstName }} {{ $inquiry->host->lastName }}
                                </small>
                            </p>
                            <p class="mb-0"><small>{{ Str::limit($inquiry->message, 100) }}</small></p>
                        </div>
                        <div class="col-md-3 text-end">
                            <p class="text-muted mb-2">
                                <small>{{ $inquiry->created_at->diffForHumans() }}</small>
                            </p>

                            <a href="{{ route('tenant.inquiry.chat', $inquiry) }}"
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
                <small>You haven't sent any inquiries yet.</small>
            </div>
            @endforelse
        </div>
    </div>

    <style>
        .nav-pills .nav-link {
            background-color: #fff;
            /* Bootstrap black */
            color: #000;
            transition: 0.3s;
        }

        .nav-pills .nav-link:hover {
            background-color: #000;
            /* Pure black on hover */
            color: #fff;
        }

        .nav-pills .nav-link.active {
            background-color: #000;
            /* Active tab pure black */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }
    </style>
</div>