<div class="overflow-hidden">
    <div class="vh-100 overflow-auto">
        {{-- Header Section --}}
        <div class="container py-5">

            {{-- Hosts Grid --}}
            <div class="mt-3" wire:loading.remove>
                @if($hosts->count() > 0)
                <div class="row g-4 mb-2">
                    @foreach($hosts as $host)
                    <div class="col-6 col-sm-6 col-lg-4 col-xl-3">
                        <a href="{{ route('verified-host-info', $host->id) }}"
                            wire:navigate
                            class="text-decoration-none">
                            <div class="host-card shadow-sm rounded-4 p-4 position-relative h-100">
                                {{-- Profile Image --}}
                                <div class="d-flex justify-content-center mb-3 mt-4">
                                    @if($host->profile_image)
                                    <img
                                        src="{{ asset('storage/' . $host->profile_image) }}"
                                        alt="{{ $host->firstName }} {{ $host->lastName }}"
                                        class="rounded-circle object-fit-cover border border-3 border-white shadow"
                                        style="width: 100px; height: 100px;">
                                    @else
                                    @php
                                    $initials = strtoupper(substr($host->firstName, 0, 1) . substr($host->lastName, 0, 1));
                                    @endphp
                                    <div class="rounded-circle d-flex justify-content-center align-items-center bg-dark text-white fw-bold border border-3 border-white shadow"
                                        style="width: 100px; height: 100px; font-size: 40px;">
                                        {{ $initials }}
                                    </div>
                                    @endif
                                </div>

                                {{-- Name + Email --}}
                                <div class="lh-1 mb-4">
                                    <h6 class="fw-semibold mb-1 text-center text-dark">
                                        {{ ucfirst($host->firstName) }} {{ ucfirst($host->lastName) }}
                                    </h6>
                                    {{-- Verified Badge (top-left) --}}
                                    <div class="text-center" style="z-index: 10;">
                                        <span class="badge rounded-pill" style="background-color: #dcfce7; color: #166534; font-size: 11px; font-weight: 600; padding: 6px 12px;">
                                        <i class="fas fa-check-circle me-1" style="font-size: 10px;"></i>
                                        Verified
                                    </span>
                                    </div>
                                </div>

                                {{-- Bottom Buttons --}}
                                <div class="row gx-2">
                                    <div class="col-6">
                                        <button
                                            onclick="event.preventDefault(); event.stopPropagation();"
                                            class="btn btn-dark btn-sm w-100 d-flex justify-content-center align-items-center gap-1 rounded-pill">
                                            <small>connect</small>
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button
                                            onclick="event.preventDefault(); event.stopPropagation();"
                                            class="btn btn-outline-dark btn-sm w-100 d-flex justify-content-center align-items-center gap-1 rounded-pill">
                                            <small>message</small>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center">
                    {{ $hosts->links() }}
                </div>

                @else
                {{-- Empty State --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-search fs-1 text-muted"></i>
                    </div>
                    <h4 class="fw-semibold mb-2">No Hosts Found</h4>
                    <p class="text-muted mb-4">
                        @if($search)
                        No hosts match your search "{{ $search }}"
                        @else
                        There are no verified hosts at the moment
                        @endif
                    </p>
                    @if($search)
                    <button
                        wire:click="$set('search', '')"
                        class="btn btn-primary rounded-pill">
                        <i class="bi bi-arrow-clockwise me-2"></i>
                        Clear Search
                    </button>
                    @endif
                </div>
                @endif
            </div>
        </div>
        <style>
            /* Host Card with Grid Background */
            .host-card {
                background-color: #f8f9fa;
                background-image:
                    linear-gradient(#dee2e6 1px, transparent 1px),
                    linear-gradient(90deg, #dee2e6 1px, transparent 1px);
                background-size: 30px 30px;
                position: relative;
                overflow: hidden;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            /* Gradient fade overlay */
            .host-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(to bottom, rgba(248, 249, 250, 0) 0%, rgba(248, 249, 250, 1) 100%);
                z-index: 0;
                pointer-events: none;
            }

            /* Ensure children are above the fade */
            .host-card>* {
                position: relative;
                z-index: 1;
            }

            /* Hover effect */
            .host-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2) !important;
            }

            /* Card entrance animation */
            .host-card {
                animation: fadeSlideUp 0.5s ease-in-out;
            }

            @keyframes fadeSlideUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </div>
</div>