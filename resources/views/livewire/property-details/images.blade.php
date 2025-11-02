<div class="container-fluid px-0">
    @if(!empty($images))
    <div class="image-gallery">
        <div id="propertyCarousel" class="carousel slide rounded-4 shadow-sm overflow-hidden" data-bs-ride="carousel">

            {{-- Main Carousel --}}
            <div class="carousel-inner">
                @foreach($images as $index => $img)
                <div class="carousel-item {{ $index === $activeIndex ? 'active' : '' }}">
                    <div class="zoom-container">
                        <img src="{{ asset('storage/' . $img) }}"
                            class="d-block w-100 zoomable"
                            alt="Property Image {{ $index + 1 }}"
                            data-index="{{ $index }}">
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Carousel Controls --}}
            <button class="carousel-control-prev enhanced-btn" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                <i class="bi bi-chevron-left fs-4"></i>
            </button>

            <button class="carousel-control-next enhanced-btn" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                <i class="bi bi-chevron-right fs-4"></i>
            </button>

            {{-- Toggle Thumbnails Button --}}
            <button id="toggleThumbnails"
                type="button"
                wire:click="toggleThumbnails"
                class="toggle-btn badge bg-dark bg-opacity-75 border-0">
                <i class="bi {{ $showThumbnails ? 'bi-grid' : 'bi-grid-fill' }}"></i>
            </button>

            {{-- Thumbnails Overlay --}}
            @if(count($images) > 1)
            <div class="thumbnails-overlay {{ !$showThumbnails ? 'hidden' : '' }}">
                <div class="d-flex justify-content-center gap-2 overflow-auto px-3 py-2">
                    @foreach($images as $index => $img)
                    <div class="thumbnail-wrapper"
                        wire:click="setActiveSlide({{ $index }})"
                        role="button"
                        aria-label="Show image {{ $index + 1 }}">
                        <img src="{{ asset('storage/' . $img) }}"
                            class="thumbnail {{ $activeIndex === $index ? 'active' : '' }}"
                            alt="Thumbnail {{ $index + 1 }}">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
    @else
    <div class="text-center p-5 rounded-4 bg-light">
        <i class="bi bi-image fs-1 text-secondary mb-3 d-block"></i>
        <p class="text-muted mb-0">No images available for this property.</p>
    </div>
    @endif

    {{-- Styles --}}
    <style>
        .image-gallery {
            --thumbnail-size: 80px;
        }

        .enhanced-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(6px);
            border-radius: 50%;
            color: #fff;
            z-index: 5;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .carousel:hover .enhanced-btn {
            opacity: 1;
        }

        .enhanced-btn:hover {
            background: rgba(0, 0, 0, 0.7);
            transform: translateY(-50%) scale(1.05);
        }

        .carousel-control-prev.enhanced-btn {
            left: 1rem;
        }

        .carousel-control-next.enhanced-btn {
            right: 1rem;
        }

        .zoom-container {
            overflow: hidden;
            position: relative;
        }

        .zoom-container img.zoomable {
            width: 100%;
            height: 385px;
            /* desktop default */
            object-fit: cover;
            transition: transform 0.4s ease;
            cursor: default;
        }

        /* Simplified zoom without zoom cursor */
        .zoomable {
            transition: transform 0.4s ease;
            cursor: default;
            /* Normal cursor */
        }

        .zoomable:hover {
            transform: scale(1.1);
        }

        .thumbnail-wrapper {
            flex: 0 0 var(--thumbnail-size);
            cursor: pointer;
        }

        .thumbnail {
            width: var(--thumbnail-size);
            height: var(--thumbnail-size);
            object-fit: cover;
            border-radius: 0.5rem;
            opacity: 0.7;
            transition: all 0.2s ease;
            border: 2px solid transparent;
        }

        .thumbnail:hover,
        .thumbnail.active {
            opacity: 1;
            border-color: #fff;
            transform: scale(1.05);
            box-shadow: 0 0 6px rgba(255, 255, 255, 0.3);
        }

        .overflow-auto {
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
        }

        .overflow-auto::-webkit-scrollbar {
            display: none;
        }

        .thumbnails-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
            padding-top: 2rem;
            z-index: 3;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .thumbnails-overlay.hidden {
            transform: translateY(100%);
            opacity: 0;
            pointer-events: none;
        }

        .toggle-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 4;
            cursor: pointer;
            padding: 0.5rem;
            transition: all 0.2s ease;
        }

        .toggle-btn:hover {
            background-color: rgba(0, 0, 0, 0.9) !important;
        }

        @media (max-width: 768px) {
            .image-gallery {
                --thumbnail-size: 50px;
            }

            .enhanced-btn {
                opacity: 1;
                background: rgba(0, 0, 0, 0.3);
            }

            .thumbnails-overlay {
                padding-top: 1rem;
            }
        }
    </style>
</div>