<div class="d-flex justify-content-center">
    <div class="card border-0 shadow-sm rounded-4 py-4 text-center host-card w-100 ">
        <div class="d-flex flex-column align-items-center position-relative" style="z-index: 2;">

            <!-- Profile display -->
            <div class="position-relative host-photo-wrapper mb-4">
                <div class="rounded-circle overflow-hidden border border-dark-subtle shadow-sm bg-white"
                    style="width: 180px; height: 180px;">
                    @if ($host && $host->profile_photo)
                        <img src="{{ asset('storage/' . $host->profile_photo) }}"
                            alt="{{ $host->firstname }}"
                            class="w-100 h-100 object-fit-cover">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                            <i class="bi bi-person fs-1 text-secondary"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Host info -->
            <span class="fw-medium fs-6 mb-0 text-dark">
                {{ $host->firstname }} {{ $host->lastname }}
            </span>
            <span class="text-muted small mt-0 mb-3">Host since {{ $host->created_at->format('Y') }}</span>

            <!-- Buttons -->
            <div class="d-flex flex-column flex-md-row gap-2">
                <button class="btn btn-dark btn-sm rounded-3 shadow-sm hover-zoom">
                    <i class="bi bi-chat-dots me-1"></i>
                    <small>Message Host</small>
                </button>
                <button class="btn btn-outline-dark btn-sm rounded-3 shadow-sm hover-zoom">
                    <i class="bi bi-person-badge me-1"></i>
                    <small>View {{ $host->firstname }}’s Info</small>
                </button>
            </div>
        </div>
    </div>

    <style>
        /* 🌟 Modern background: crisp diagonal + horizontal lines with fade */
        .host-card {
            position: relative;
            overflow: hidden;
            background-color: #f8f9fa;
        }

    .host-card::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
        /* Diagonal lines */
        linear-gradient(
            135deg,
            rgba(0, 0, 0, 0.08) 0%,
            rgba(0, 0, 0, 0.08) 1px,
            transparent 1px
        ),
        /* Horizontal lines */
        linear-gradient(
            to bottom,
            rgba(0, 0, 0, 0.05) 0%,
            rgba(0, 0, 0, 0.05) 1px,
            transparent 1px
        ),
        /* Vertical lines */
        linear-gradient(
            to right,
            rgba(0, 0, 0, 0.05) 0%,
            rgba(0, 0, 0, 0.05) 1px,
            transparent 1px
        );
    background-size: 60px 60px; /* spacing for all line patterns */
    mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%);
    -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%);
    z-index: 0;
}


        /* Subtle pulse ring */
        @keyframes hostPulse {
            0% {
                transform: scale(1);
                border-color: rgba(33, 37, 41, 0.8);
            }
            50% {
                transform: scale(1.05);
                border-color: rgba(33, 37, 41, 0.2);
            }
            100% {
                transform: scale(1);
                border-color: rgba(33, 37, 41, 0.8);
            }
        }

        .host-photo-wrapper {
            position: relative;
            width: 180px;
            height: 180px;
            z-index: 2;
        }

        .host-photo-wrapper::after {
            content: '';
            position: absolute;
            top: -6px;
            left: -6px;
            right: -6px;
            bottom: -6px;
            border: 1px solid #212529;
            border-radius: 50%;
            z-index: 3;
        }

        /* Button hover animation */
        .hover-zoom {
            transition: all 0.2s ease-in-out;
        }

        .hover-zoom:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
    </style>
</div>
