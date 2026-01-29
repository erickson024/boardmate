<div wire:poll.10s="pollNotifications">
    <div class="dropdown position-relative" x-data="{ open: false }" @click.outside="open = false">
        <button
            class="btn btn-sm btn-light btn-outline-dark shadow-sm border-1 rounded-5 position-relative"
            type="button"
            @click="open = !open"
            aria-expanded="false">
            <i class="bi bi-bell-fill"></i>
            @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
            @endif
        </button>

        <div class="dropdown-menu dropdown-menu-end p-0 shadow-lg border-0 show"
            style="width: 380px; border-radius: 12px; overflow: hidden; position: absolute; top: 100%; right: 0; margin-top: 0.5rem; z-index: 1050;"
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom" style="background-color: #ffffff;">
                <div>
                    <p class="mb-0 fw-medium text-dark fs-6">Notifications</p>
                    @if($unreadCount > 0)
                    <small class="text-muted" style="font-size: 0.8rem;">{{ $unreadCount }} unread</small>
                    @endif
                </div>
                @if($unreadCount > 0)
                <button
                    wire:click.stop="markAllAsRead"
                    class="btn btn-link btn-sm text-decoration-none p-0 fw-semibold"
                    style="font-size: 0.85rem; color: #0066cc;">
                    Mark all as read
                </button>
                @endif
            </div>

            <!-- Time Sections -->
            <div class="overflow-auto" style="max-height: calc(80vh - 180px); min-height: 300px; background-color: #fafafa;">
                @php
                $groupedNotifications = $notifications->groupBy(function($notification) {
                $created = $notification->created_at;
                if ($created->isToday()) return 'TODAY';
                if ($created->isYesterday()) return 'YESTERDAY';
                if ($created->isCurrentWeek()) return 'THIS WEEK';
                return 'OLDER';
                });
                @endphp

                @forelse($groupedNotifications as $timeGroup => $groupNotifications)
                <!-- Time Section Header -->
                <div class="px-4 pt-3 pb-2">
                    <small class="text-muted fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">{{ $timeGroup }}</small>
                </div>

                @foreach($groupNotifications as $notification)
                <div
                    class="notification-item mx-3 mb-2 p-3 rounded-3 {{ is_null($notification->read_at) ? 'bg-white' : 'bg-white bg-opacity-50' }}"
                    style="cursor: pointer; border: 1px solid #e8e8e8; transition: all 0.2s ease;"
                    wire:click.stop="markAsRead('{{ $notification->id }}')"
                    onmouseover="this.style.backgroundColor='#f5f5f5'; this.style.borderColor='#d0d0d0';"
                    onmouseout="this.style.backgroundColor='{{ is_null($notification->read_at) ? '#ffffff' : 'rgba(255, 255, 255, 0.5)' }}'; this.style.borderColor='#e8e8e8';">

                    <div class="d-flex align-items-start gap-3">
                        <!-- Icon/Avatar based on notification type -->
                        <div class="flex-shrink-0 mt-1">
                            @if(isset($notification->data['type']))
                            @if($notification->data['type'] === 'success')
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #e8f5e9;">
                                <i class="bi bi-check-circle-fill" style="color: #4caf50; font-size: 1.2rem;"></i>
                            </div>
                            @elseif($notification->data['type'] === 'danger')
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #ffebee;">
                                <i class="bi bi-x-circle-fill" style="color: #f44336; font-size: 1.2rem;"></i>
                            </div>
                            @elseif($notification->data['type'] === 'mention')
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #e3f2fd;">
                                <i class="bi bi-person-fill" style="color: #2196f3; font-size: 1.2rem;"></i>
                            </div>
                            @elseif($notification->data['type'] === 'file')
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #f3e5f5;">
                                <i class="bi bi-file-earmark-fill" style="color: #9c27b0; font-size: 1.2rem;"></i>
                            </div>
                            @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #e8eaf6;">
                                <i class="bi bi-bell-fill" style="color: #5e35b1; font-size: 1.2rem;"></i>
                            </div>
                            @endif
                            @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: #e8eaf6;">
                                <i class="bi bi-bell-fill" style="color: #5e35b1; font-size: 1.2rem;"></i>
                            </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-grow-1 min-w-0">
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                <p class="mb-0 fw-medium fs-6 text-dark lh-1">
                                    {{ $notification->data['title'] ?? 'Notification' }}
                                </p>
                                @if(is_null($notification->read_at))
                                <span class="badge rounded-circle p-0" style="width: 8px; height: 8px; background-color: #0066cc;"></span>
                                @endif
                            </div>

                            <p class="mb-2 text-muted" style="font-size: 0.85rem; line-height: 1.5;">
                                {{ $notification->data['message'] ?? '' }}
                            </p>

                            <!-- Meta Information -->
                            <div class="d-flex align-items-center gap-2 mb-2 fw-medium">
                                <small class="text-muted d-flex align-items-center gap-1">
                                    <i class="bi bi-clock" style="font-size: 0.7rem;"></i>
                                    {{ $notification->created_at->diffForHumans() }}
                                </small>
                                @if(isset($notification->data['context']))
                                <span class="text-muted" style="font-size: 0.75rem;">•</span>
                                <small class="text-muted d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-tag" style="font-size: 0.7rem;"></i>
                                    {{ $notification->data['context'] }}
                                </small>
                                @endif
                            </div>

                            <!-- File Preview (if applicable) -->
                            @if(isset($notification->data['file_name']))
                            <div class="d-flex align-items-center gap-2 p-2 rounded-2" style="background-color: #f5f5f5; border: 1px solid #e0e0e0;">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #e8f5e9;">
                                    <i class="bi bi-file-earmark-spreadsheet-fill" style="color: #4caf50; font-size: 1.1rem;"></i>
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <div class="fw-medium text-truncate" style="font-size: 0.8rem; color: #1a1a1a;">
                                       {{ $notification->data['file_name'] }}
                                    </div>
                                    @if(isset($notification->data['file_size']))
                                    <small class="text-muted" style="font-size: 0.7rem;">
                                        {{ $notification->data['file_size'] }}
                                    </small>
                                    @endif
                                </div>
                                <button class="btn btn-sm btn-light rounded-circle" style="width: 32px; height: 32px; padding: 0;">
                                    <i class="bi bi-download" style="font-size: 0.9rem;"></i>
                                </button>
                            </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 mt-2">
                                @if(isset($notification->data['action_url']))
                                <a
                                    href="{{ $notification->data['action_url'] }}"
                                    class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                    style="font-size: 0.8rem; font-weight: 500;"
                                    wire:navigate>
                                    {{ $notification->data['action_label'] ?? 'View' }}
                                </a>
                                @endif

                                <button
                                    wire:click.stop="deleteNotification('{{ $notification->id }}')"
                                    class="btn btn-sm btn-outline-secondary rounded-pill fw-semibold px-3"
                                    style="font-size: 0.8rem;">
                                    <i class="bi bi-trash" style="font-size: 0.75rem;"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @empty
                <div class="p-5 text-center">
                    <div class="mb-3">
                        <i class="bi bi-bell-slash" style="font-size: 3rem; color: #d0d0d0;"></i>
                    </div>
                    <p class="mb-1 fw-semibold fs-6 text-secondary">No notifications yet</p>
                    <small class="text-muted" style="font-size: 0.85rem;">We'll notify you when something arrives</small>
                </div>
                @endforelse
            </div>

            <!-- Footer -->
            @if($notifications->count() > 0)
            <div class="p-3 border-top text-center" style="background-color: #ffffff;">
                <a href="{{ route('notifications') }}" class="btn btn-link text-decoration-none fw-semibold" style="color: #0066cc; font-size: 0.9rem;" wire:navigate>
                    View all notifications
                </a>
            </div>
            @endif
        </div>
    </div>

    <style>
        .notification-item {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .notification-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .dropdown-menu {
            animation: slideDown 0.2s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom scrollbar */
        .overflow-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .overflow-auto::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .overflow-auto::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</div>