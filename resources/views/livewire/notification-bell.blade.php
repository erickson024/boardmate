<div class="dropdown">
    <button
        class="btn btn-sm btn-light btn-outline-dark shadow-sm border-1 rounded-5 position-relative"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false">
        <i class="bi bi-bell-fill"></i>
        @if($unreadCount > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
        </span>
        @endif
    </button>

    <div class="dropdown-menu dropdown-menu-end p-0 shadow-lg rounded mt-3" style="width: 380px; max-height: 500px;">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center p-3 border-bottom bg-light rounded">
            <h6 class="mb-0 fw-semibold"><small>Notifications</small></h6>
            @if($unreadCount > 0)
            <button
                wire:click="markAllAsRead"
                class="btn btn-link btn-sm text-decoration-none p-0 fw-semibold"
                style="font-size: 0.8rem;">
                Mark all as read
            </button>
            @endif
        </div>

        <!-- Notifications List -->
        <div class="overflow-auto" style="max-height: 400px;">
            @forelse($notifications as $notification)
            <div
                class="p-3 border-bottom {{ is_null($notification->read_at) ? 'bg-light bg-opacity-50' : '' }}"
                style="cursor: pointer;"
                wire:click="markAsRead('{{ $notification->id }}')">

                <div class="d-flex align-items-start gap-2">
                    <!-- Icon based on notification type -->
                    <div class="flex-shrink-0">
                        @if(isset($notification->data['type']))
                        @if($notification->data['type'] === 'success')
                        <div class="bg-success bg-opacity-10 rounded-circle p-2">
                            <i class="bi bi-check-circle-fill text-success"></i>
                        </div>
                        @elseif($notification->data['type'] === 'danger')
                        <div class="btn btn-sm btn-dark">
                            <i class="bi bi-x"></i>
                        </div>
                        @elseif($notification->data['type'] === 'info')
                        <div class="bg-info bg-opacity-10 rounded-circle p-2">
                            <i class="bi bi-info-circle-fill text-info"></i>
                        </div>
                        @else
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                            <i class="bi bi-bell-fill text-primary"></i>
                        </div>
                        @endif
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-semibold" style="font-size: 0.9rem;">
                            {{ $notification->data['title'] ?? 'Notification' }}
                        </h6>
                        <p class="mb-1 text-muted" style="font-size: 0.85rem;">
                            {{ $notification->data['message'] ?? '' }}
                        </p>
                        <small class="text-muted" style="font-size: 0.75rem;">
                            <i class="bi bi-clock"></i> {{ $notification->created_at->diffForHumans() }}
                        </small>

                        <!-- Action Button if available -->
                        @if(isset($notification->data['action_url']))
                        <div class="mt-2">
                            <a
                                href="{{ $notification->data['action_url'] }}"
                                class="btn btn-sm btn-outline-dark fw-medium"
                                wire:navigate>
                                <small>View Details</small>
                            </a>
                        </div>
                        @endif
                    </div>

                    <!-- Unread indicator -->
                    @if(is_null($notification->read_at))
                    <div class="flex-shrink-0">
                        <span class="badge bg-primary rounded-circle p-1" style="width: 8px; height: 8px;"></span>
                    </div>
                    @endif
                </div>
                <!-- Delete button (appears on hover) -->
                <div class="text-end">
                    <button
                        wire:click.stop="deleteNotification('{{ $notification->id }}')"
                        class="btn btn-sm btn-danger ">
                        <small>
                            <i class="bi bi-trash"></i> Delete
                        </small>
                    </button>
                </div>
            </div>
            @empty
            <div class="p-5 text-center text-muted">
                <i class="bi bi-bell-slash fs-1"></i>
                <p class="mb-0 mt-2 fw-medium"><small>No notifications yet</small></p>
                <small>We'll notify you when something arrives</small>
            </div>
            @endforelse
        </div>

        <!-- Footer -->
        @if($notifications->count() > 0)
        <div class="p-2 border-top text-center bg-light">
            <a href="{{ route('notifications') }}" class="btn btn-link btn-sm text-decoration-none text-dark fw-medium" wire:navigate>
                <small>View All Notifications</small>
            </a>
        </div>
        @endif
    </div>
</div>