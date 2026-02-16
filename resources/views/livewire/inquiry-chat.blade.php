<div class="container-fluid" style="margin-top: 5%;">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">

            {{-- Header --}}
            <div class="row mb-3">
                <div class="col-9 col-md-6">
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
                <div class="col-3 col-md-6 text-end">
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

                            {{-- VISIT SCHEDULING CARD (Appears in messages) --}}
                            @if($inquiry->status === 'accepted' && $userRole === 'tenant')
                            @if(!$visit)
                            {{-- No visit scheduled - Show schedule card --}}
                            <div class="mb-3">
                                <div class="card border-0 shadow-sm" style="max-width: 85%;">
                                    <div class="card-body rounded border border-dark bg-light">
                                        @if(!$showVisitForm)
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex flex-row">
                                                <div class="bg-primary rounded p-3 text-light me-2">
                                                    <i class="bi bi-calendar-check-fill"></i>
                                                </div>
                                                <div class="">
                                                    <h6 class="mb-1">
                                                        Schedule Property Visit
                                                    </h6>
                                                    <small class="text-muted">Ready to see the property? Pick a date and time.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            wire:click="toggleVisitForm"
                                            class="btn btn-sm btn-dark mt-2 w-100">
                                            <small>
                                                <i class="bi bi-calendar-plus"></i> Schedule Now
                                            </small>
                                        </button>

                                        @else
                                        {{-- Visit Form --}}
                                        <div wire:ignore.self>
                                            <h6 class="mb-3">
                                                <i class="bi bi-calendar-check text-primary"></i>
                                                Schedule Your Visit
                                            </h6>
                                            <form wire:submit.prevent="scheduleVisit">
                                                <div class="mb-2">
                                                    <x-floating-labels.input
                                                        label="Preferred Date & Time"
                                                        id="proposedDate"
                                                        type="datetime-local"
                                                        wire:model="proposedDate"
                                                        min="{{ now()->addDay()->format('Y-m-d\TH:i') }}" />
                                                </div>
                                                <div class="mb-3">
                                                    <x-floating-labels.input
                                                        label="Any questions or special requests."
                                                        id="visitNotes"
                                                        wire:model="visitNotes"
                                                        rows="2" />
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-sm btn-dark" wire:loading.attr="disabled" wire:target="scheduleVisit">
                                                        <span wire:loading.remove wire:target="scheduleVisit">
                                                            <small>
                                                                <i class="bi bi-send"></i> Send Request
                                                            </small>
                                                        </span>
                                                        <span wire:loading wire:target="scheduleVisit">
                                                            <span class="spinner-border spinner-border-sm"></span>
                                                        </span>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-dark" wire:click="toggleVisitForm">
                                                        <small>
                                                            Cancel
                                                        </small>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            @elseif($visit->status === 'pending')
                            {{-- Visit requested - waiting for host --}}
                            <div class="mb-3">
                                <div class="card border-warning" style="max-width: 85%;">
                                    <div class="card-body bg-opacity-10">
                                        <div class="d-flex flex-row mb-2">
                                            <div class="bg-warning text-white p-3 rounded me-2 d-flex align-items-center">
                                                <i class="bi bi-clock-history"></i>
                                            </div>
                                            <div class="">
                                                <p class="mb-0 fw-medium">Visit Request Pending</p>
                                                <p class="fw-light mt-0 mb-0"><small>Requested Date:</small></p>
                                                <p class="fw-light mt-0 mb-1"><small>{{ $visit->proposed_date->format('l, F j, Y \a\t g:i A') }}</small></p>
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="alert alert-warning mb-0 py-2">
                                                <small>
                                                    <i class="bi bi-hourglass-split"></i>
                                                    Waiting for {{ $inquiry->host->firstName }} to confirm ...
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @elseif($visit->status === 'confirmed')
                            {{-- Visit confirmed --}}
                            <div class="mb-3">
                                <div class="card border-success" style="max-width: 85%;">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="bg-success p-3 d-flex text-light align-items-center me-2 rounded">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </div>

                                            <div class="">
                                                <p class="mb-0 fw-medium">Visit Confirmed!</p>
                                                <p class="mt-0 mb-0 fw-light"><small><strong>Date & Time:</strong></small></p>
                                                <p class="mb-0 fw-light"><small>{{ $visit->confirmed_date->format('l, F j, Y \a\t g:i A') }}</small></p>
                                                @if($visit->host_instructions)
                                                <p class="mb-1"><small><strong>Host Instructions:</strong></small></p>
                                                <div class="alert alert-info mb-0 py-2">
                                                    <small>{{ $visit->host_instructions }}</small>
                                                </div>
                                                @endif
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            @elseif($visit->status === 'completed')
                            {{-- Visit completed --}}
                            <div class="mb-3">
                                <div class="card border-info" style="max-width: 85%;">
                                    <div class="card-body">
                                        <div class="d-flex flex-row">
                                            <div class="bg-info p-3 d-flex align-items-center text-light me-2 rounded">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </div>
                                            <div class="">
                                                <p class="mb-0 fw-medium">Visit Completed</p>
                                                <p class="mt-0 mb-0 fw-light"><small>Property visit was completed successfully.</small></p>
                                            </div>
                                        </div>

                                        <div class="alert alert-primary mb-0 mt-2 py-2">
                                            <small>
                                                <strong>Next Step:</strong> Wait for the host to send the lease agreement.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif


                            {{-- HOST VIEW: Visit Management in Messages --}}
                            @if($inquiry->status === 'accepted' && $userRole === 'host' && $visit)
                            @if($visit->status === 'pending')
                            <div class="mb-3 text-end" wire:key="host-visit-pending-{{ $visit->id }}">
                                <div class="card border-warning d-inline-block" style="max-width: 85%;">
                                    <div class="card-body bg-opacity-10 text-start">
                                        <div class="d-flex flex-row mb-2">
                                            <div class="bg-warning d-flex align-items-center text-light p-3 me-2 rounded">
                                                <i class="bi bi-calendar-event"></i>
                                            </div>
                                            <div class="">
                                                <p class="fw-medium mb-0">Visit Request from {{ $inquiry->tenant->firstName }}</p>
                                                <p class="fw-light mt-0 mb-0"><small><strong>Requested Date:</strong></small></p>
                                                <p class="fw-light mt-0 mb-0"><small>{{ $visit->proposed_date->format('l, F j, Y \a\t g:i A') }}</small></p>
                                            </div>
                                        </div>

                                        <button
                                            wire:click="confirmVisit({{ $visit->id }})"
                                            class="btn btn-sm btn-dark w-100"
                                            wire:loading.attr="disabled"
                                            wire:target="confirmVisit"
                                            wire:key="confirm-visit-btn-{{ $visit->id }}">
                                            <span wire:loading.remove wire:target="confirmVisit">
                                                <small class="fw-semibold">
                                                    <i class="bi bi-check"></i> Confirm This Visit
                                                </small>
                                            </span>
                                            <span wire:loading wire:target="confirmVisit">
                                                <span class="spinner-border spinner-border-sm"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @elseif($visit->status === 'confirmed')
                            <div class="mb-3 text-end" wire:key="host-visit-confirmed-{{ $visit->id }}">
                                <div class="card border-success d-inline-block" style="max-width: 85%;">
                                    <div class="card-body bg-opacity-10 text-start">
                                        <div class="d-flex flex-row mb-2">
                                            <div class="bg-success d-flex align-items-center text-light p-3 me-2 rounded">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </div>
                                            <div class="">
                                                <p class="fw-medium mb-0">Visit Confirmed</p>
                                                <p class="fw-ligth mb-0 mt-0"><small>Date & Time:</small></p>
                                                <p class="fw-ligth mb-0 mt-0"><small>{{ $visit->confirmed_date->format('l, F j, Y \a\t g:i A') }}</small></p>
                                            </div>
                                        </div>

                                        <button
                                            wire:click="completeVisit({{ $visit->id }})"
                                            class="btn btn-sm btn-dark w-100"
                                            wire:loading.attr="disabled"
                                            wire:target="completeVisit"
                                            wire:key="complete-visit-btn-{{ $visit->id }}">
                                            <span wire:loading.remove wire:target="completeVisit">
                                                <small class="fw-semibold">
                                                    <i class="bi bi-check-circle"></i> Mark as Completed
                                                </small>
                                            </span>
                                            <span wire:loading wire:target="completeVisit">
                                                <span class="spinner-border spinner-border-sm"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @elseif($visit->status === 'completed')
                            <div class="mb-3 text-end" wire:key="host-visit-completed-{{ $visit->id }}">
                                <div class="card border-info d-inline-block" style="max-width: 85%;">
                                    <div class="card-body bg-opacity-10 text-start">
                                        <div class="d-flex flex-row">
                                            <div class="bg-info p-3 d-flex align-items-center text-light me-2 rounded">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </div>
                                            <div class="">
                                                <p class="mb-0 fw-medium">Visit Completed</p>
                                                <p class="mt-0 mb-0 fw-light"><small>Property visit was completed successfully.</small></p>
                                            </div>
                                        </div>

                                        <div class="alert alert-primary mb-0 mt-2 py-2">
                                            <small>
                                                <strong>Next Step:</strong> Send lease agreement if you want to proceed.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif

                            {{-- LEASE AGREEMENT SECTION --}}
                            @if($inquiry->status === 'accepted' && $visit && $visit->status === 'completed')

                            {{-- HOST: Send Lease Agreement --}}
                            @if($userRole === 'host' && !$lease)
                            <div class="mb-3 text-end" wire:key="host-lease-form">
                                <div class="card shadow d-inline-block" style="max-width: 85%;">
                                    <div class="card-body border-0 text-start">
                                        @if(!$showLeaseForm)

                                        <div class="d-flex flex-row">
                                            <div class="bg-dark p-3 d-flex align-items-center text-light me-2 rounded">
                                                <i class="bi bi-file-text"></i>
                                            </div>
                                            <div class="">
                                                <p class="fw-medium mb-0">Send Lease Agreement</p>
                                                <p class="fw-light mt-0"><small>Ready to proceed? Send the lease agreement to the tenant.</small></p>
                                            </div>
                                        </div>
                                        <button
                                            wire:click="toggleLeaseForm"
                                            class="btn btn-sm btn-dark mt-2 w-100 fw-semibold"
                                            wire:key="toggle-lease-btn">
                                            <small>
                                                <i class="bi bi-file-plus"></i> Create Lease
                                            </small>
                                        </button>
                                        @else
                                        {{-- WRAP THE FORM WITH wire:ignore.self --}}
                                        <div wire:ignore.self>
                                            <h6 class="mb-3">
                                                <i class="bi bi-file-earmark-text"></i>
                                                Lease Agreement Details
                                            </h6>
                                            <form wire:submit.prevent="sendLeaseAgreement">
                                                <div class="mb-2">
                                                    <x-floating-labels.input
                                                        type="date"
                                                        label="Start Date"
                                                        id="leaseStartDate"
                                                        wire:model="leaseStartDate"
                                                        min="{{ now()->addDay()->format('Y-m-d') }}" />
                                                </div>
                                                <div class="mb-2">
                                                    <x-floating-labels.input
                                                        label="End Date"
                                                        type="date"
                                                        id="leaseEndDate"
                                                        wire:model="leaseEndDate" />
                                                </div>
                                                <div class="mb-2">
                                                    <x-floating-labels.input
                                                        label="Monthly Rent"
                                                        id="monthly-rent"
                                                        type="text"
                                                        value="₱{{ number_format($inquiry->property->propertyCost, 2) }}"
                                                        disabled />
                                                </div>
                                                <div class="mb-2">
                                                    <x-floating-labels.input
                                                        label="Security Deposit"
                                                        id="securityDeposit"
                                                        wire:model="securityDeposit"
                                                        type="number"
                                                        value="₱{{ number_format($inquiry->property->propertyCost, 2) }}"
                                                        step="0.01" />
                                                </div>
                                                <div class="mb-3">
                                                    <x-floating-labels.text-area
                                                        label="Special Conditions (Optional)"
                                                        id="specialConditions"
                                                        wire:model="specialConditions"
                                                        rows="3" />
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-dark"
                                                        wire:loading.attr="disabled"
                                                        wire:target="sendLeaseAgreement">
                                                        <span wire:loading.remove wire:target="sendLeaseAgreement">
                                                            <small>
                                                                <i class="bi bi-send"></i> Send Lease
                                                            </small>
                                                        </span>
                                                        <span wire:loading wire:target="sendLeaseAgreement">
                                                            <span class="spinner-border spinner-border-sm"></span>
                                                        </span>
                                                    </button>
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-outline-dark"
                                                        wire:click="toggleLeaseForm">
                                                        <small>
                                                            Cancel
                                                        </small>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- TENANT: View and Sign Lease --}}
                            @if($userRole === 'tenant' && $lease)
                            @if($lease->status === 'sent')
                            <div class="mb-3" wire:key="tenant-lease-{{ $lease->id }}">
                                <div class="card border-primary" style="max-width: 85%;">
                                    <div class="card-body bg-light">
                                        <h6 class="mb-2">
                                            <i class="bi bi-file-earmark-text text-primary"></i>
                                            Lease Agreement Received
                                        </h6>
                                        <div class="mb-2">
                                            <small><strong>Duration:</strong> {{ $lease->start_date->format('M j, Y') }} - {{ $lease->end_date->format('M j, Y') }}</small>
                                        </div>
                                        <div class="mb-2">
                                            <small><strong>Monthly Rent:</strong> ₱{{ number_format($lease->monthly_rent, 2) }}</small>
                                        </div>
                                        <div class="mb-2">
                                            <small><strong>Security Deposit:</strong> ₱{{ number_format($lease->security_deposit, 2) }}</small>
                                        </div>
                                        @if($lease->special_conditions)
                                        <div class="mb-2">
                                            <small><strong>Special Conditions:</strong></small>
                                            <p class="mb-0"><small>{{ $lease->special_conditions }}</small></p>
                                        </div>
                                        @endif
                                        <button
                                            wire:click="signLease({{ $lease->id }})"
                                            class="btn btn-sm btn-success w-100 mt-2"
                                            wire:loading.attr="disabled"
                                            wire:target="signLease"
                                            wire:key="sign-lease-btn-{{ $lease->id }}">
                                            <span wire:loading.remove wire:target="signLease">
                                                <i class="bi bi-pen"></i> Sign & Accept
                                            </span>
                                            <span wire:loading wire:target="signLease">
                                                <span class="spinner-border spinner-border-sm"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @elseif($lease->status === 'signed')
                            <div class="mb-3">
                                <div class="card border-success" style="max-width: 85%;">
                                    <div class="card-body">
                                        <div class="d-flex flex-row mb-2">
                                            <div class="bg-success p-3 d-flex align-items-center text-light me-2 rounded mb-2">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </div>
                                            <div class="">
                                                <p class="mb-0 fw-medium">Lease Agreement Signed! </p>
                                                <p class="mb-0 mt-0"><small>Congratulations! Your lease has been signed.</small></p>
                                            </div>
                                        </div>

                                        <div class="alert alert-info mb-0 mt-2 py-2">
                                            <small><strong>Move-in Date:</strong> {{ $lease->start_date->format('F j, Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif

                            {{-- HOST: View Lease Status --}}
                            @if($userRole === 'host' && $lease)
                            @if($lease->status === 'sent')
                            <div class="mb-3 text-end">
                                <div class="card border-info d-inline-block" style="max-width: 85%;">
                                    <div class="card-body bg-info bg-opacity-10 text-start">
                                        <h6 class="mb-2">
                                            <i class="bi bi-hourglass-split text-info"></i>
                                            Lease Agreement Sent
                                        </h6>
                                        <p class="mb-0"><small>Waiting for {{ $inquiry->tenant->firstName }} to sign...</small></p>
                                    </div>
                                </div>
                            </div>
                            @elseif($lease->status === 'signed')
                            <div class="mb-3 text-end">
                                <div class="card border-success d-inline-block" style="max-width: 85%;">
                                    <div class="card-body">
                                        <div class="d-flex flex-row mb-2">
                                            <div class="bg-success p-3 d-flex align-items-center text-light me-2 rounded">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </div>
                                            <div class="text-start">
                                                <p class="mb-0 fw-medium">Lease Agreement Signed!</p>
                                                <p class="mb-0 mt-0 fw-light"><small>Tenant has signed the lease agreement.</small></p>
                                            </div>
                                        </div>

                                        <div class="alert alert-primary text-center mb-0 mt-2 py-2">
                                            <small><strong>Move-in Date:</strong> {{ $lease->start_date->format('F j, Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif
                            @endif

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
                                        class="form-control form-control-sm @error('newMessage') is-invalid @enderror py-2"
                                        wire:model.live.debounce.500ms="newMessage"
                                        rows="1"
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
        console.log('Status changed to:', event.status);
        setTimeout(scrollToBottom, 100);
    });

    // Scroll when visit form is opened
    Livewire.on('visit-form-opened', () => {
        setTimeout(scrollToBottom, 100);
    });

    document.addEventListener('livewire:updated', () => {
        scrollToBottom();
    });
</script>
@endpush