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
                        <span class="text-muted mb-2"><small>{{ $inquiry->property->address }} | ₱{{ number_format($inquiry->property->propertyCost, 0) }} monthly</small></span>
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
                    <div class="card" style="height: 410px; display: flex; flex-direction: column;">
                        {{-- Messages Container --}}
                        <div class="card-body flex-grow-1 overflow-auto" id="messages-container" style="max-height: 480px;">
                            @forelse($messages as $message)
                            <div class="mb-3 {{ $message->sender_id === Auth::id() ? 'text-end' : '' }}">
                                <div class="d-inline-block" style="max-width: 70%;">
                                    {{-- Sender Info --}}
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

                                    {{-- Message Bubble --}}
                                    <div class="p-3 rounded {{ $message->sender_id === Auth::id() ? 'bg-dark text-white' : 'bg-light' }}">
                                        <p class="mb-0" style="white-space: pre-wrap;">{{ $message->message }}</p>
                                    </div>

                                    {{-- Read Receipt --}}
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
                        </div>

                        {{-- Message Input --}}
                        <div class="card-footer bg-white border-top">
                            <form wire:submit.prevent="sendMessage">
                                <div class="input-group">
                                    <textarea
                                        class="form-control @error('newMessage') is-invalid @enderror"
                                        wire:model="newMessage"
                                        rows="2"
                                        placeholder="Type your message..."
                                        wire:keydown.enter.prevent="sendMessage"></textarea>
                                    <button
                                        type="submit"
                                        class="btn btn-dark"
                                        wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="sendMessage">
                                            <i class="bi bi-send"></i> Send
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
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">

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
                                    <small class="text-muted">property host</small>
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
                                    {{ $inquiry->status === 'accepted' ? 'disabled' : '' }}>
                                    <i class="bi bi-check-circle"></i> Accept
                                </button>
                                <button
                                    class="btn btn-sm btn-danger"
                                    wire:click="updateStatus('rejected')"
                                    {{ $inquiry->status === 'rejected' ? 'disabled' : '' }}>
                                    <i class="bi bi-x-circle"></i> Reject
                                </button>
                                <button
                                    class="btn btn-sm btn-outline-dark"
                                    wire:click="updateStatus('closed')"
                                    {{ $inquiry->status === 'closed' ? 'disabled' : '' }}>
                                    <i class="bi bi-lock"></i> Close
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-scroll to bottom on load and new messages
    function scrollToBottom() {
        const container = document.getElementById('messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    }

    // Scroll on page load
    document.addEventListener('DOMContentLoaded', scrollToBottom);

    // Scroll when new message is sent
    Livewire.on('message-sent', () => {
        setTimeout(scrollToBottom, 100);
    });

    // Auto-scroll on Livewire updates
    document.addEventListener('livewire:updated', () => {
        scrollToBottom();
    });
</script>
@endpush