<div class="container-fluid" style="margin-top: 5%;">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
    

            {{-- Header --}}
            <div class="row mb-3">
                <div class="col-6">
                    <div class="d-flex flex-row">
                        <a href="{{ $userRole === 'tenant' ? route('tenant.inquiries') : route('host.inquiries') }}"
                            type="button"
                            class="btn btn-dark me-2 d-flex align-items-center"
                            wire:navigate>
                            <i class="bi bi-arrow-bar-left"></i>
                        </a>
                        <div class="d-flex flex-column">
                            <h5 class="mb-0">{{ $inquiry->subject }}</h5>
                            <span class="text-muted mb-2">
                                <small>{{ $inquiry->property->address }} | ₱{{ number_format($inquiry->property->propertyCost, 0) }} monthly</small>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-6 text-end">
                    <span class="badge bg-{{ $inquiry->status === 'pending' ? 'warning' : ($inquiry->status === 'replied' ? 'info' : ($inquiry->status === 'accepted' ? 'success' : ($inquiry->status === 'rejected' ? 'danger' : 'secondary'))) }}">
                        <span class="fw-medium p-3" style="font-size: 13px;">{{ ucfirst($inquiry->status) }}</span>
                    </span>
                </div>
            </div>

            <div class="row">
                {{-- Chat Area --}}
                <div class="col-lg-8">
                    <div class="card mb-2" style="height: 395px; display: flex; flex-direction: column;">
                        {{-- Messages Container with polling --}}
                        <div class="card-body flex-grow-1 overflow-auto"
                            id="messages-container"
                            style="max-height: 480px;"
                            wire:poll.2s="checkForNewMessages">
                            @forelse($messages as $message)
                            <div class="mb-3 {{ $message->sender_id === Auth::id() ? 'text-end' : '' }}"
                                wire:key="message-{{ $message->id }}">
                                <div class="d-inline-block" style="max-width: 70%;">
                                    <div class="mb-1">
                                        <small class="text-muted">
                                            @if($message->sender_id === Auth::id())
                                            You
                                            @else
                                            {{ $message->sender->firstName }} {{ $message->sender->lastName }}
                                            @endif
                                            · {{ $message->created_at->diffForHumans() }}
                                        </small>
                                    </div>

                                    <div class="p-3 rounded {{ $message->sender_id === Auth::id() ? 'bg-dark text-white' : 'bg-light' }}">
                                        <p class="mb-0" style="white-space: pre-wrap;">{{ $message->message }}</p>
                                    </div>

                                    @if($message->sender_id === Auth::id() && $message->isRead())
                                    <div class="mt-1">
                                        <small class="text-muted">
                                            <i class="bi bi-check-all"></i> Read
                                        </small>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="text-center text-muted mt-5">
                                <i class="bi bi-chat-dots fs-1"></i>
                                <p class="mt-2">No messages yet</p>
                            </div>
                            @endforelse

                            {{-- Typing Indicator --}}
                            @if($otherUserTyping)
                            <div class="mb-3">
                                <div class="d-inline-block">
                                    <div class="p-2 rounded bg-light" style="max-width: 70px;">
                                        <div class="typing-dots">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <small class="text-muted">typing...</small>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- Message Input --}}
                        <div class="m-2" wire:key="message-input-footer">
                            @if(in_array($inquiry->status, ['rejected', 'closed']))
                            {{-- Chat is closed --}}
                            <div class="alert alert-secondary text-center mb-0">
                                <small>
                                    <i class="bi bi-lock"></i>
                                    This conversation has been
                                    {{ $inquiry->status === 'rejected' ? 'closed by the host' : 'closed' }}.
                                </small>
                            </div>
                            @else
                            {{-- Normal chat input --}}
                            <form wire:submit.prevent="sendMessage" wire:key="message-form">
                                <div class="input-group input-group-sm" wire:key="message-input-group">
                                    <textarea
                                        class="form-control form-control-sm @error('newMessage') is-invalid @enderror"
                                        wire:model.live.debounce.500ms="newMessage"
                                        rows="2"
                                        placeholder="Type a message"
                                        wire:keydown.enter.prevent="sendMessage"
                                        wire:key="message-textarea"></textarea>
                                    <button
                                        type="submit"
                                        class="btn btn-dark btn-sm d-flex align-items-center px-3"
                                        wire:loading.attr="disabled"
                                        wire:target="sendMessage"
                                        wire:key="send-button">
                                        <span wire:loading.remove wire:target="sendMessage">
                                            <i class="bi bi-send"></i>
                                        </span>
                                        <span wire:loading wire:target="sendMessage">
                                            <span class="spinner-border spinner-border-sm"></span>
                                        </span>
                                    </button>
                                </div>

                                @error('newMessage')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </form>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4" wire:key="sidebar">
                    {{-- Contact Info --}}
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-body">
                            @php
                            $otherUser = $userRole === 'tenant' ? $inquiry->host : $inquiry->tenant;
                            @endphp

                            <div class="d-flex align-items-center">
                                @if($otherUser->profile_image)
                                <img src="{{ asset('storage/' . $otherUser->profile_image) }}"
                                    class="rounded-circle me-3"
                                    style="width: 50px; height: 50px; object-fit: cover;"
                                    alt="{{ $otherUser->firstName }}">
                                @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 50px; height: 50px; background: #000; color: white;">
                                    <span class="fw-bold">
                                        {{ strtoupper(substr($otherUser->firstName, 0, 1)) }}{{ strtoupper(substr($otherUser->lastName, 0, 1)) }}
                                    </span>
                                </div>
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $otherUser->firstName }} {{ $otherUser->lastName }}</h6>
                                    <small class="text-muted">
                                        @if($userRole === 'tenant')
                                        property host
                                        @else
                                        tenant
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status Management (Host Only) --}}
                    @if($userRole === 'host')
                    <div class="card border border-0 shadow-sm">
                        <div class="card-header border border-0 bg-white">
                            <h6 class="mb-0">Manage Inquiry</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button
                                    class="btn btn-sm btn-success"
                                    wire:click="updateStatus('accepted')"
                                    wire:loading.attr="disabled"
                                    {{ $inquiry->status === 'accepted' ? 'disabled' : '' }}>
                                    <span wire:loading.remove wire:target="updateStatus('accepted')">
                                        <i class="bi bi-check-circle"></i> Accept
                                    </span>
                                    <span wire:loading wire:target="updateStatus('accepted')">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </span>
                                </button>
                                <button
                                    class="btn btn-sm btn-danger"
                                    wire:click="updateStatus('rejected')"
                                    wire:loading.attr="disabled"
                                    {{ $inquiry->status === 'rejected' ? 'disabled' : '' }}>
                                    <span wire:loading.remove wire:target="updateStatus('rejected')">
                                        <i class="bi bi-x-circle"></i> Reject
                                    </span>
                                    <span wire:loading wire:target="updateStatus('rejected')">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </span>
                                </button>
                                <button
                                    class="btn btn-sm btn-outline-dark"
                                    wire:click="updateStatus('closed')"
                                    wire:loading.attr="disabled"
                                    {{ $inquiry->status === 'closed' ? 'disabled' : '' }}>
                                    <span wire:loading.remove wire:target="updateStatus('closed')">
                                        <i class="bi bi-lock"></i> Close
                                    </span>
                                    <span wire:loading wire:target="updateStatus('closed')">
                                        <span class="spinner-border spinner-border-sm"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('styles')
    <style>
        .typing-dots {
            display: flex;
            gap: 4px;
            align-items: center;
            justify-content: center;
            padding: 8px 0;
        }

        .typing-dots span {
            width: 8px;
            height: 8px;
            background-color: #6c757d;
            border-radius: 50%;
            animation: typing 1.4s infinite;
        }

        .typing-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {

            0%,
            60%,
            100% {
                transform: translateY(0);
                opacity: 0.7;
            }

            30% {
                transform: translateY(-10px);
                opacity: 1;
            }
        }
    </style>
    @endpush
</div>

@push('scripts')
<script>
    function scrollToBottom() {
        const container = document.getElementById('messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }

    document.addEventListener('DOMContentLoaded', scrollToBottom);

    Livewire.on('message-sent', () => {
        setTimeout(scrollToBottom, 100);
    });

    Livewire.on('message-received', () => {
        setTimeout(scrollToBottom, 100);
    });

    Livewire.on('status-changed', (event) => {
        // Optional: Show a toast notification
        console.log('Status changed to:', event.status);
        setTimeout(scrollToBottom, 100);
    });

    document.addEventListener('livewire:updated', () => {
        scrollToBottom();
    });
</script>
@endpush