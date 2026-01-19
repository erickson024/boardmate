<div class="row g-0">

    <!-- Property Images -->
    <div class="col-12 col-md-6 px-4" style="margin-top: 5%;">
        <div class="row mb-3">
            <div class="col-12 d-flex flex-row">
                <button
                    type="button"
                    class="btn btn-dark me-2"
                    wire:click="backHome">
                    <i class="bi bi-arrow-bar-left"></i>
                </button>
                <div class="">
                    <p class="fw-semibold fs-4 mb-0">{{ $property->propertyName }}</p>
                    <div class="d-flex align-items-center text-muted mt-0">
                        <small>
                            <span>{{ $property->address }}</span>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Property Images Gallery --}}
        <div class="row g-2 mb-2">
            @php
            $images = is_array($property->images) ? $property->images : [];
            @endphp

            @if(!empty($images))
            {{-- Main Image --}}
            <div class="col-12 col-md-5">
                <img src="{{ asset('storage/' . $images[0]) }}"
                    class="w-100 rounded-3"
                    style="height: 350px; object-fit: cover;"
                    alt="{{ $property->propertyName }}">
            </div>

            {{-- Side Images --}}
            <div class="col-12 col-md-7">
                <div class="row g-2">
                    @foreach(array_slice($images, 1, 4) as $index => $image)
                    <div class="col-6">
                        <img src="{{ asset('storage/' . $image) }}"
                            class="w-100 rounded-3"
                            style="height: 170px; object-fit: cover;"
                            alt="{{ $property->propertyName }}">
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="col-12">
                <img src="{{ asset('images/no-image.jpg') }}"
                    class="w-100 rounded-3"
                    style="height: 400px; object-fit: cover;"
                    alt="No Image Available">
            </div>
            @endif
        </div>

        {{-- Scroll Down Indicator (place after images) --}}
        <div class="text-center">
            <div class="d-inline-flex flex-column align-items-center scroll-indicator">
                <span style="color: #64748b; font-size: 12px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase;">
                    Scroll for more details
                </span>
                <div class="arrow-container" style="position: relative; height: 20px;">
                    <i class="bi bi-chevron-down arrow-bounce" style="color: #94a3b8; font-size: 20px; position: absolute; top: 0;"></i>
                    <i class="bi bi-chevron-down arrow-bounce-delayed" style="color: #94a3b8; font-size: 20px; position: absolute; top: 8px; opacity: 0.6;"></i>
                </div>
            </div>
        </div>
    </div>

    <style>
        .scroll-indicator {
            animation: fadeIn 1s ease-out 0.5s forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .arrow-bounce {
            animation: bounceArrow 2s ease-in-out infinite;
        }

        .arrow-bounce-delayed {
            animation: bounceArrow 2s ease-in-out infinite 0.2s;
        }

        @keyframes bounceArrow {

            0%,
            100% {
                transform: translateY(0);
                opacity: 0.8;
            }

            50% {
                transform: translateY(12px);
                opacity: 0.3;
            }
        }

        /* Pulse effect on hover */
        .scroll-indicator:hover .arrow-bounce,
        .scroll-indicator:hover .arrow-bounce-delayed {
            animation-duration: 1s;
        }
    </style>

    <!-- Map and Controls -->
    <div class="col-12 col-md-6" style=" height: 100vh; display: flex; flex-direction: column;">

        {{-- Map Container --}}
        <div class="position-relative map-container" id="map-container" style="border-radius: 0; overflow: hidden; box-shadow: none; flex: 1; width: 100%; margin-top: 8%;">

            {{-- Loading state --}}
            <div id="map" style="height: 100%; width: 100%;"></div>

            {{-- Map controls overlay --}}
            <div class="position-absolute top-0 end-0 m-3 d-flex flex-column gap-3" style="z-index: 5;">
                <button
                    id="recenter-btn"
                    class="btn btn-light rounded-circle shadow-lg"
                    style="width: 50px; height: 50px; transition: all 0.3s ease; border: none; font-size: 18px;"
                    title="Recenter map">
                    <i class="bi bi-crosshair"></i>
                </button>
                <button
                    id="satellite-toggle"
                    class="btn btn-light rounded-circle shadow-lg"
                    style="width: 50px; height: 50px; transition: all 0.3s ease; border: none; font-size: 18px;"
                    title="Toggle satellite view">
                    <i class="bi bi-globe"></i>
                </button>
                <button
                    id="custom-route-btn"
                    class="btn rounded-circle shadow-lg"
                    style="width: 50px; height: 50px; transition: all 0.3s ease; border: none; font-size: 18px; background: linear-gradient(135deg, #007bff, #0056b3); color: white;"
                    title="Add custom route">
                    <i class="bi bi-geo"></i>
                </button>
            </div>
            <style>
                #recenter-btn:hover,
                #satellite-toggle:hover {
                    transform: scale(1.1);
                    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2) !important;
                }

                #custom-route-btn:hover {
                    transform: scale(1.1);
                    box-shadow: 0 8px 16px rgba(0, 91, 187, 0.4) !important;
                }
            </style>

            {{-- User Location Route Info Card --}}
            <div id="user-route-info" class="position-absolute bottom-0 start-0 m-3 bg-white rounded-3 shadow p-3" style="max-width: 300px; display: none; animation: slideInUp 0.3s ease; border: 1px solid #e5e7eb;">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background-color: #dbeafe;">
                        <i class="bi bi-car-front-fill" style="color: #1e40af; font-size: 18px;"></i>
                    </div>
                    <div class="flex-grow-1" style="min-width: 0;">
                        <div class="mb-2">
                            <p class="mb-0 fw-semibold" style="color: #111827; font-size: 14px; letter-spacing: -0.01em;">Route to Property</p>
                            <span class="badge rounded-pill" style="background-color: #dbeafe; color: #1e40af; font-size: 10px; font-weight: 500; padding: 3px 8px; letter-spacing: 0.02em;">YOUR LOCATION</span>
                        </div>
                        <div class="d-flex align-items-center mb-1" style="gap: 8px;">
                            <i class="bi bi-geo-alt-fill" style="color: #9ca3af; font-size: 13px;"></i>
                            <p class="mb-0" id="user-route-distance" style="color: #4b5563; font-size: 13px; font-weight: 500;">Calculating route...</p>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <i class="bi bi-clock-fill" style="color: #9ca3af; font-size: 13px;"></i>
                            <p class="mb-0" id="user-route-duration" style="color: #4b5563; font-size: 13px; font-weight: 500;"></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Custom Address Route Info Card --}}
            <div id="custom-route-info" class="position-absolute bottom-0 start-0 bg-white rounded-3 shadow p-3" style="max-width: 300px; display: none; animation: slideInUp 0.3s ease; border: 1px solid #e5e7eb; margin-bottom: 10rem !important; margin-left: 1rem;">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background-color: #dcfce7;">
                        <i class="bi bi-pin-map-fill" style="color: #15803d; font-size: 18px;"></i>
                    </div>
                    <div class="flex-grow-1" style="min-width: 0;">
                        <div class=" mb-2">
                            <p class="mb-0 fw-semibold" style="color: #111827; font-size: 14px; letter-spacing: -0.01em;">Custom Route</p>
                            <span class="badge rounded-pill" style="background-color: #dcfce7; color: #15803d; font-size: 10px; font-weight: 500; padding: 3px 8px; letter-spacing: 0.02em;">CUSTOM ADDRESS</span>
                        </div>
                        <div class="d-flex align-items-center mb-1" style="gap: 8px;">
                            <i class="bi bi-geo-alt-fill" style="color: #9ca3af; font-size: 13px;"></i>
                            <p class="mb-0" id="custom-route-distance" style="color: #4b5563; font-size: 13px; font-weight: 500;">Calculating route...</p>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <i class="bi bi-clock-fill" style="color: #9ca3af; font-size: 13px;"></i>
                            <p class="mb-0" id="custom-route-duration" style="color: #4b5563; font-size: 13px; font-weight: 500;"></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Custom Route Panel --}}
            <div id="custom-route-panel" class="position-absolute top-0 start-0 m-3 bg-white rounded-3 shadow p-3" style="max-width: 320px; display: none; z-index: 10; animation: slideInLeft 0.3s ease; border: 1px solid #e5e7eb;">
                <div class="d-flex align-items-start justify-content-between mb-3 pb-3" style="border-bottom: 1px solid #f3f4f6;">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-semibold d-flex align-items-center" style="font-size: 14px; color: #111827; letter-spacing: -0.01em;">
                            <i class="bi bi-geo-alt-fill me-2" style="color: #6b7280; font-size: 15px;"></i>Route from Address
                        </h6>
                        <small style="color: #9ca3af; font-size: 12px;">Enter a starting location</small>
                    </div>
                    <button
                        id="close-route-panel"
                        class="btn btn-sm rounded-2 p-0 d-flex align-items-center justify-content-center"
                        style="width: 32px; height: 32px; background: #f9fafb; border: 1px solid #e5e7eb; transition: all 0.2s ease;">
                        <i class="bi bi-x" style="font-size: 20px; color: #6b7280;"></i>
                    </button>
                </div>

                <div class="mb-3">
                    <label for="custom-address-input" class="form-label mb-2" style="color: #374151; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Starting Address</label>
                    <div class="position-relative">
                        <input
                            type="text"
                            id="custom-address-input"
                            class="form-control rounded-2"
                            style="padding: 10px 36px 10px 12px; font-size: 14px; border: 1px solid #d1d5db; background-color: #fff; transition: all 0.2s ease; color: #111827;"
                            placeholder="Search for an address"
                            autocomplete="off">
                        <i class="bi bi-search position-absolute" style="right: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; pointer-events: none; font-size: 14px;"></i>
                    </div>
                    <div id="address-suggestions" class="mt-2 rounded-2" style="display: none; max-height: 200px; overflow-y: auto; background-color: #f9fafb; border: 1px solid #e5e7eb;"></div>
                </div>

                <button
                    id="route-submit-btn"
                    class="btn w-100 rounded-2"
                    style="background-color: #111827; color: white; font-weight: 500; font-size: 13px; padding: 10px; border: none; transition: all 0.2s ease; letter-spacing: 0.01em;"
                    disabled>
                    <i class="bi bi-arrow-right-circle me-2" style="font-size: 14px;"></i>Show Route
                </button>

                <button
                    id="clear-route-btn"
                    class="btn w-100 rounded-2 mt-2"
                    style="border: 1px solid #e5e7eb; color: #6b7280; background: white; font-weight: 500; font-size: 13px; padding: 9px; transition: all 0.2s ease; display: none;"
                    onmouseover="this.style.borderColor='#d1d5db'; this.style.backgroundColor='#f9fafb';"
                    onmouseout="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='white';">
                    <i class="bi bi-arrow-counterclockwise me-2" style="font-size: 14px;"></i>Clear Route
                </button>
            </div>
            <style>
                @keyframes slideInLeft {
                    from {
                        opacity: 0;
                        transform: translateX(-20px);
                    }

                    to {
                        opacity: 1;
                        transform: translateX(0);
                    }
                }

                #custom-route-panel {
                    backdrop-filter: blur(10px);
                    background-color: rgba(255, 255, 255, 0.98);
                }

                #custom-address-input:focus {
                    border-color: #9ca3af !important;
                    box-shadow: 0 0 0 3px rgba(156, 163, 175, 0.1);
                    outline: none;
                }

                #route-submit-btn:not(:disabled) {
                    cursor: pointer;
                }

                #route-submit-btn:not(:disabled):hover {
                    background-color: #1f2937;
                    transform: translateY(-1px);
                    box-shadow: 0 4px 12px rgba(17, 24, 39, 0.15);
                }

                #route-submit-btn:disabled {
                    opacity: 0.5;
                    cursor: not-allowed;
                }

                #close-route-panel:hover {
                    background-color: #f3f4f6 !important;
                    border-color: #d1d5db;
                }

                #close-route-panel:hover i {
                    color: #374151;
                }

                #clear-route-btn:hover {
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
                }
            </style>

            {{-- Route info card --}}
            <div id="route-info" class="position-absolute bottom-0 start-0 m-3 bg-white rounded-3 shadow p-3" style="max-width: 300px; display: none; animation: slideInUp 0.3s ease; border: 1px solid #e5e7eb;">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; background-color: #f8f9fa;">
                        <i class="bi bi-car-front-fill" style="color: #374151; font-size: 18px;"></i>
                    </div>
                    <div class="flex-grow-1" style="min-width: 0;">
                        <div class="d-column align-items-center mb-2">
                            <p class="mb-0 fw-semibold" style="color: #111827; font-size: 14px; letter-spacing: -0.01em;" id="route-title">Route to Property</p>
                            <span class="badge rounded-pill" id="route-type-badge" style="background-color: #f3f4f6; color: #f3f4f6; font-size: 10px; font-weight: 500; padding: 3px 8px; letter-spacing: 0.02em;">LOCATION</span>
                        </div>
                        <div class="d-flex align-items-center mb-1" style="gap: 8px;">
                            <i class="bi bi-geo-alt-fill" style="color: #9ca3af; font-size: 13px;"></i>
                            <p class="mb-0" id="route-distance" style="color: #4b5563; font-size: 13px; font-weight: 500;">Calculating route...</p>
                        </div>
                        <div class="d-flex align-items-center" style="gap: 8px;">
                            <i class="bi bi-clock-fill" style="color: #9ca3af; font-size: 13px;"></i>
                            <p class="mb-0" id="route-duration" style="color: #4b5563; font-size: 13px; font-weight: 500;"></p>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                @keyframes slideInUp {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                #route-info {
                    backdrop-filter: blur(10px);
                    background-color: rgba(255, 255, 255, 0.98);
                }
            </style>
        </div>
    </div>

    <!-- Tenant Information Cards -->
    <div class="col-12 mb-4">
        <div class="tenant-info-card position-relative overflow-hidden"
            style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%); border: 1px solid rgba(255, 255, 255, 0.08); padding: 60px 40px;">

            <!-- Background decoration -->
            <div class="position-absolute" style="top: -50px; right: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
            <div class="position-absolute" style="bottom: -50px; left: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(139, 92, 246, 0.08) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

            <div class="row g-4 align-items-center">
                <!-- Property Cost Section -->
                <div class="col-6 col-lg-3 text-center tenant-section">
                    <div class="mb-3"
                        style="width: 56px; height: 56px; background: rgba(34, 197, 94, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto; border: 1px solid rgba(34, 197, 94, 0.2);">
                        <i class="bi bi-cash-stack" style="color: #4ade80; font-size: 26px;"></i>
                    </div>

                    <p class="mb-2"
                        style="color: #94a3b8; font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase;">
                        Monthly Rate
                    </p>

                    <p class="mb-1"
                        style="color: #f8fafc; font-size: 28px; font-weight: 700; letter-spacing: -0.02em; line-height: 1;">
                        ₱{{ number_format($property->propertyCost, 0) }}
                    </p>

                    <p class="mb-0"
                        style="color: #cbd5e1; font-size: 15px; font-weight: 500; letter-spacing: 0.01em;">
                        Per Month
                    </p>
                </div>

                <!-- Property Type Section -->
                <div class="col-6 col-lg-3 text-center tenant-section">
                    <div class="mb-3"
                        style="width: 56px; height: 56px; background: rgba(245, 158, 11, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto; border: 1px solid rgba(245, 158, 11, 0.2);">
                        <i class="bi bi-house-door-fill" style="color: #fbbf24; font-size: 26px;"></i>
                    </div>

                    <p class="mb-2"
                        style="color: #94a3b8; font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase;">
                        Property Type
                    </p>

                    <p class="mb-1"
                        style="color: #f8fafc; font-size: 28px; font-weight: 700; letter-spacing: -0.02em; line-height: 1;">
                        {{ $property->propertyType }}
                    </p>

                    <p class="mb-0"
                        style="color: #cbd5e1; font-size: 15px; font-weight: 500; letter-spacing: 0.01em;">
                        Category
                    </p>
                </div>

                <!-- Looking For Section -->
                <div class="col-6 col-lg-3 text-center tenant-section">
                    <div class="mb-3"
                        style="width: 56px; height: 56px; background: rgba(59, 130, 246, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto; border: 1px solid rgba(59, 130, 246, 0.2);">
                        <i class="bi bi-people-fill" style="color: #60a5fa; font-size: 26px;"></i>
                    </div>

                    <p class="mb-2"
                        style="color: #94a3b8; font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase;">
                        Looking For
                    </p>

                    <p class="mb-1"
                        style="color: #f8fafc; font-size: 28px; font-weight: 700; letter-spacing: -0.02em; line-height: 1;">
                        {{ $property->tenantGender }}
                    </p>

                    <p class="mb-0"
                        style="color: #cbd5e1; font-size: 15px; font-weight: 500; letter-spacing: 0.01em;">
                        Tenant
                    </p>
                </div>

                <!-- Preferably Section -->
                <div class="col-6 col-lg-3 text-center tenant-section">
                    <div class="mb-3"
                        style="width: 56px; height: 56px; background: rgba(139, 92, 246, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto; border: 1px solid rgba(139, 92, 246, 0.2);">
                        <i class="bi bi-person-badge-fill" style="color: #a78bfa; font-size: 26px;"></i>
                    </div>

                    <p class="mb-2"
                        style="color: #94a3b8; font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase;">
                        Preferably
                    </p>

                    <p class="mb-1"
                        style="color: #f8fafc; font-size: 28px; font-weight: 700; letter-spacing: -0.02em; line-height: 1;">
                        {{ $property->tenantType }}
                    </p>

                    <p class="mb-0"
                        style="color: #cbd5e1; font-size: 15px; font-weight: 500; letter-spacing: 0.01em;">
                        Type
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .tenant-info-card {
            opacity: 0;
            transform: translateY(40px);
            animation: fadeInUp 0.8s ease-out forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tenant-section {
            opacity: 0;
            transform: translateY(20px);
            animation: sectionFadeIn 0.6s ease-out forwards;
        }

        .tenant-section:nth-child(1) {
            animation-delay: 0.2s;
        }

        .tenant-section:nth-child(2) {
            animation-delay: 0.3s;
        }

        .tenant-section:nth-child(3) {
            animation-delay: 0.4s;
        }

        .tenant-section:nth-child(4) {
            animation-delay: 0.5s;
        }

        @keyframes sectionFadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .tenant-section {
                padding-bottom: 20px;
            }

            .tenant-section:not(:last-child) {
                border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            }
        }

        @media (min-width: 992px) {
            .tenant-section:not(:last-child) {
                border-right: 1px solid rgba(255, 255, 255, 0.08);
            }
        }
    </style>

    <!-- Property Features -->
    <div class="col-12 mb-4">
        <div class="container">
            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <div class="d-inline-flex align-items-center gap-2 mb-3 px-3 py-2" style="background-color: #f1f5f9; border-radius: 20px;">
                        <i class="fas fa-star" style="color: #f59e0b; font-size: 12px;"></i>
                        <span style="color: #475569; font-size: 11px; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;">Property Features</span>
                    </div>
                    <p class="mb-2 fs-4  fw-semibold" style="color: #0f172a; letter-spacing: -0.02em; line-height: 1.2;">
                        What This Property Offers
                    </p>
                    <small class="mb-0 mx-auto text-muted">
                        Explore the amenities and features that make this property stand out from the rest.
                    </small>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="row g-3">
                @php
                // Font Awesome icon mapping
                $featureIcons = [
                // Utilities & Comfort
                'Wi-Fi' => 'fa-wifi',
                'Telephone' => 'fa-phone',
                'Air Conditioning' => 'fa-snowflake',
                'Heater' => 'fa-temperature-high',
                'Electric Fan' => 'fa-fan',

                // Entertainment
                'Smart TV' => 'fa-tv',
                'Cable TV' => 'fa-satellite-dish',
                'Karaoke' => 'fa-microphone',

                // Bathroom
                'Hot Shower' => 'fa-shower',
                'Bathtub' => 'fa-bath',
                'Smart Toilet' => 'fa-toilet',

                // Interior
                'Fully Furnished' => 'fa-couch',
                'Wardrobe / Closet' => 'fa-door-closed',
                'Balcony' => 'fa-building',
                'Laundry Area' => 'fa-tshirt',

                // Kitchen
                'Kitchen' => 'fa-utensils',
                'Refrigerator' => 'fa-snowflake',
                'Microwave' => 'fa-fire',
                'Rice Cooker' => 'fa-bowl-rice',

                // Security
                'CCTV' => 'fa-video',
                '24/7 Guarded' => 'fa-shield-alt',
                'Gated Property' => 'fa-dungeon',
                'Fire Alarm' => 'fa-fire-extinguisher',

                // Parking
                'Parking Space' => 'fa-car',
                'Motorcycle Parking' => 'fa-motorcycle',

                // Nearby Locations
                'Near School' => 'fa-graduation-cap',
                'Near Market' => 'fa-store',
                'Near Convenience Store' => 'fa-shopping-basket',
                'Near Public Transport' => 'fa-bus',
                'Near Park' => 'fa-tree',
                'Near Hospital' => 'fa-hospital',
                'Near Police Station' => 'fa-shield',
                ];

                // Color mapping (converting Bootstrap classes to hex)
                $colorMap = [
                'bg-primary' => ['bg' => '#dbeafe', 'icon' => '#2563eb'],
                'bg-warning' => ['bg' => '#fef3c7', 'icon' => '#f59e0b'],
                'bg-dark' => ['bg' => '#e2e8f0', 'icon' => '#475569'],
                'bg-info' => ['bg' => '#e0f2fe', 'icon' => '#0ea5e9'],
                'bg-secondary' => ['bg' => '#f3f4f6', 'icon' => '#6b7280'],
                'bg-danger' => ['bg' => '#fee2e2', 'icon' => '#ef4444'],
                'bg-success' => ['bg' => '#d1fae5', 'icon' => '#10b981'],
                ];

                $featureColors = [
                // Utilities & Comfort
                'Wi-Fi' => 'bg-primary',
                'Telephone' => 'bg-primary',
                'Air Conditioning' => 'bg-primary',
                'Heater' => 'bg-primary',
                'Electric Fan' => 'bg-primary',

                // Entertainment
                'Smart TV' => 'bg-warning',
                'Cable TV' => 'bg-warning',
                'Karaoke' => 'bg-warning',

                // Bathroom
                'Hot Shower' => 'bg-dark',
                'Bathtub' => 'bg-dark',
                'Smart Toilet' => 'bg-dark',

                // Interior
                'Fully Furnished' => 'bg-info',
                'Wardrobe / Closet' => 'bg-info',
                'Balcony' => 'bg-info',
                'Laundry Area' => 'bg-info',

                // Kitchen
                'Kitchen' => 'bg-secondary',
                'Refrigerator' => 'bg-secondary',
                'Microwave' => 'bg-secondary',
                'Rice Cooker' => 'bg-secondary',

                // Security
                'CCTV' => 'bg-danger',
                '24/7 Guarded' => 'bg-danger',
                'Gated Property' => 'bg-danger',
                'Fire Alarm' => 'bg-danger',

                // Parking
                'Parking Space' => 'bg-secondary',
                'Motorcycle Parking' => 'bg-secondary',

                // Nearby Locations
                'Near School' => 'bg-success',
                'Near Market' => 'bg-success',
                'Near Convenience Store' => 'bg-success',
                'Near Public Transport' => 'bg-success',
                'Near Park' => 'bg-success',
                'Near Hospital' => 'bg-success',
                'Near Police Station' => 'bg-success',
                ];

                $propertyFeatures = is_array($property->propertyFeatures) ? $property->propertyFeatures : [];
                @endphp

                @if(!empty($propertyFeatures))
                @foreach($propertyFeatures as $index => $feature)
                @php
                $colorClass = $featureColors[$feature] ?? 'bg-secondary';
                $colors = $colorMap[$colorClass];
                @endphp
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="feature-card h-100 p-3 rounded-3"
                        style="background-color: #ffffff; border: 1px solid #e5e7eb; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); cursor: default; animation: fadeInUp 0.5s ease-out forwards; animation-delay: {{ $index * 0.05 }}s; opacity: 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-shrink-0 feature-icon-wrapper"
                                style="width: 48px; height: 48px; background-color: {{ $colors['bg'] }}; border-radius: 12px; display: flex; align-items: center; justify-content: center; transition: transform 0.3s ease;">
                                <i class="fas {{ $featureIcons[$feature] ?? 'fa-check-circle' }}"
                                    style="color: {{ $colors['icon'] }}; font-size: 20px;"></i>
                            </div>
                            <div class="flex-grow-1" style="min-width: 0;">
                                <h6 class="mb-0" style="color: #1e293b; font-size: 14px; font-weight: 600; letter-spacing: -0.01em; line-height: 1.4;">
                                    {{ $feature }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12">
                    <div class="text-center py-5 px-4 rounded-3" style="background-color: #f8fafc; border: 2px dashed #e2e8f0;">
                        <div class="mb-3" style="width: 64px; height: 64px; background-color: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="fas fa-inbox" style="font-size: 28px; color: #94a3b8;"></i>
                        </div>
                        <h6 class="mb-2" style="color: #475569; font-weight: 600;">No Features Listed</h6>
                        <p class="mb-0" style="color: #94a3b8; font-size: 14px;">This property doesn't have any features listed yet.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .feature-card {
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, transparent 0%, rgba(0, 0, 0, 0.02) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feature-card:hover {
            border-color: #cbd5e1 !important;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.08);
            transform: translateY(-4px);
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-card:hover .feature-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .feature-card {
                animation-delay: 0s !important;
            }
        }
    </style>

    <!-- Property Description -->
    <div class="col-12 bg-dark mb-4">
        <div class="container text-light py-4">
            <div class="row">
                <div class="col-12 col-md-6">
                    <p class="fw-semibold fs-4 mb-0">Property Description</p>
                    <small class="mt-0">Learn more about what makes this property unique and special.</small>
                </div>
                <div class="col-12 col-md-6">
                    <p class="lh-lg">{{ $property->propertyDescription }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Property Restrictions -->
    <div class="col-12 mb-4">
        <div class="container">
            <!-- Header Section -->
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <div class="d-inline-flex align-items-center gap-2 mb-3 px-3 py-2" style="background-color: #fee2e2; border-radius: 20px;">
                        <i class="fas fa-shield-alt" style="color: #dc2626; font-size: 12px;"></i>
                        <span style="color: #991b1b; font-size: 11px; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;">House Rules</span>
                    </div>
                    <p class="mb-2 fs-4 fw-semibold" style="color: #0f172a; letter-spacing: -0.02em; line-height: 1.2;">
                        Property Restrictions
                    </p>
                    <small class="mb-0 mx-auto text-muted">
                        Please review and respect these important rules to ensure a harmonious living environment.
                    </small>
                </div>
            </div>

            <!-- Restrictions Grid -->
            <div class="row g-3">
                @php
                $propertyRestrictionIcons = [
                // Lifestyle
                'No Smoking' => 'fa-smoking-ban',
                'No Vaping' => 'fa-ban',
                'No Alcohol' => 'fa-wine-bottle',
                'No Drugs' => 'fa-pills',

                // Social Rules
                'No Parties' => 'fa-glass-cheers',
                'No Events' => 'fa-calendar-xmark',
                'No Loud Music' => 'fa-volume-xmark',

                // Pets
                'No Pets' => 'fa-dog',
                'Small Pets Only' => 'fa-paw',

                // Guests
                'No Overnight Guests' => 'fa-user-slash',
                'Limited Visitors Only' => 'fa-user-clock',
                'Registration Required for Guests' => 'fa-id-card',

                // Noise & Conduct
                'Quiet Hours Enforced' => 'fa-moon',
                'No Noise' => 'fa-volume-mute',
                'Respect Neighbors' => 'fa-handshake',
                'Curfew Enforced' => 'fa-clock',

                // Safety
                'No Cooking' => 'fa-fire-extinguisher',
                'No Open Flames' => 'fa-fire',
                'No Candles' => 'fa-fire-flame-simple',
                'No Incense' => 'fa-wind',

                // Property Care
                'No Wall Drilling' => 'fa-screwdriver',
                'No Wall Painting' => 'fa-paint-roller',
                'No Furniture Rearranging' => 'fa-couch',
                'No Nails or Hooks' => 'fa-thumbtack',

                // Usage
                'No Laundry' => 'fa-tshirt',
                'No Business Use' => 'fa-briefcase',
                'Residential Use Only' => 'fa-house-user',

                // Parking
                'No Overnight Parking' => 'fa-parking',
                'No Commercial Vehicles' => 'fa-truck',
                ];

                $propertyRestrictions = is_array($property->propertyRestrictions) ? $property->propertyRestrictions : [];
                @endphp

                @if(!empty($propertyRestrictions))
                @foreach($propertyRestrictions as $index => $restriction)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="restriction-card h-100 p-3 rounded-3"
                        style="background-color: #ffffff; border: 1px solid #fee2e2; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); cursor: default; animation: fadeInUp 0.5s ease-out forwards; animation-delay: {{ $index * 0.05 }}s; opacity: 0;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="flex-shrink-0 restriction-icon-wrapper"
                                style="width: 48px; height: 48px; background-color: #fee2e2; border-radius: 12px; display: flex; align-items: center; justify-content: center; transition: transform 0.3s ease; position: relative;">
                                <i class="fas {{ $propertyRestrictionIcons[$restriction] ?? 'fa-ban' }}"
                                    style="color: #dc2626; font-size: 20px;"></i>
                                <div class="position-absolute" style="top: -4px; right: -4px; width: 16px; height: 16px; background-color: #dc2626; border-radius: 50%; border: 2px solid #ffffff; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-times" style="color: #ffffff; font-size: 8px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1" style="min-width: 0;">
                                <h6 class="mb-0" style="color: #1e293b; font-size: 14px; font-weight: 600; letter-spacing: -0.01em; line-height: 1.4;">
                                    {{ $restriction }}
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-12">
                    <div class="text-center py-5 px-4 rounded-3" style="background-color: #f0fdf4; border: 2px dashed #bbf7d0;">
                        <div class="mb-3" style="width: 64px; height: 64px; background-color: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="fas fa-check-circle" style="font-size: 28px; color: #16a34a;"></i>
                        </div>
                        <h6 class="mb-2" style="color: #166534; font-weight: 600;">No Restrictions</h6>
                        <p class="mb-0" style="color: #15803d; font-size: 14px;">This property has no specific restrictions listed.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!--Property Terms and Condition-->
    <div class="col-12 mb-4 bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-12 ">
                    <div class="text-light py-4 text-center">
                        <p class="fw-semibold fs-4 mb-3">Terms and Condition</p>
                        <p class="lh-lg">{{$property->terms}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .restriction-card {
            position: relative;
            overflow: hidden;
        }

        .restriction-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, transparent 0%, rgba(220, 38, 38, 0.02) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .restriction-card:hover {
            border-color: #fca5a5 !important;
            box-shadow: 0 4px 16px rgba(220, 38, 38, 0.12);
            transform: translateY(-4px);
        }

        .restriction-card:hover::before {
            opacity: 1;
        }

        .restriction-card:hover .restriction-icon-wrapper {
            transform: scale(1.1);
            background-color: #fecaca !important;
        }

        .sticky-top {
            position: -webkit-sticky;
            position: sticky;
        }

        @media (max-width: 991.98px) {
            .sticky-top {
                position: relative !important;
                top: 0 !important;
            }

            .restriction-card {
                animation-delay: 0s !important;
            }
        }
    </style>

    <!-- host information cards -->
    {{-- Host Contact Information Section --}}
    <div class="col-12 mb-3">
        <div class="container">
            <div class="row g-4">
                <!-- Header -->
                <div class="col-12 text-center">
                    <div class="d-inline-flex align-items-center gap-2 mb-3 px-3 py-2" style="background-color: #dbeafe; border-radius: 20px;">
                        <i class="fas fa-user-circle" style="color: #2563eb; font-size: 12px;"></i>
                        <span style="color: #1e40af; font-size: 11px; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase;">Property Host</span>
                    </div>
                    <p class="mb-3 fs-4 fw-semibold" style="color: #0f172a; letter-spacing: -0.02em; line-height: 1.2;">
                        Get In Touch
                    </p>
                    <small class="mb-0 mx-auto text-muted">
                        Interested in this property? Contact the host directly for more information or click Inquire to schedule a visit.
                    </small>
                </div>

                <!-- Contact Card -->
                <div class="col-12 col-lg-4 mx-auto">
                    <div class="contact-card p-4 p-md-4 rounded-3 border shadow">

                        <div class="row g-4 align-items-center">
                            <!-- Host Profile -->
                            <div class="col-12 col-md-12 text-center">
                                <div class="mb-3 position-relative d-inline-block">
                                    @if($property->user->profile_picture)
                                    <img src="{{ asset('storage/' . $property->user->profile_image) }}"
                                        alt="{{ $property->user->name }}"
                                        class="rounded-circle"
                                        style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #ffffff; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                                    @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 120px; height: 120px; background: linear-gradient(135deg, #000000, #000000); border: 4px solid #ffffff; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">

                                        <span class="fs-2 text-light fw-medium">
                                            {{ strtoupper(substr($property->user->firstName, 0, 1)) }}{{ strtoupper(substr($property->user->lastName, 0, 1)) }}
                                        </span>

                                    </div>

                                    @endif

                                </div>
                                <h5 class="mb-1 fw-medium fs-5">
                                    {{ $property->user->firstName }} {{ $property->user->lastName }}
                                </h5>
                                <div class="">
                                    <span class="badge rounded-pill" style="background-color: #dcfce7; color: #166534; font-size: 11px; font-weight: 600; padding: 6px 12px;">
                                        <i class="fas fa-check-circle me-1" style="font-size: 10px;"></i>
                                        Verified Host
                                    </span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row gx-2">
                                    <div class="col-6">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-dark w-100">
                                            <span class="fw-semibold">
                                                <small>Connect</small>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-dark w-100">
                                            <span class="fw-semibold">
                                                <small>Message</small>
                                            </span>
                                        </button>
                                    </div>

                                    <div class="col-12 mt-2">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-primary w-100">
                                            <span class="fw-semibold">
                                                <small>Inquire</small>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .contact-card {
                animation: fadeInUp 0.8s ease-out forwards;
                opacity: 0;
            }

            @keyframes fadeInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .contact-btn-primary:hover {
                background-color: #1d4ed8 !important;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
            }

            .contact-btn-secondary:hover {
                background-color: #2563eb !important;
                color: #ffffff !important;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(37, 99, 235, 0.2);
            }

            .contact-btn-tertiary:hover {
                background-color: #ffffff !important;
                border-color: #cbd5e1 !important;
                color: #1e293b !important;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(15, 23, 42, 0.1);
            }

            /* Responsive adjustments */
            @media (max-width: 767.98px) {
                .contact-card {
                    padding: 24px !important;
                }
            }
        </style>



    </div>

    <script>
        (function() {
            let map, propertyMarker, userMarker, customMarker, geocoder, directionsService, directionsRenderer;
            let autocomplete, customDirectionsRenderer;
            let isSatellite = false;
            let mapInitialized = false;
            let propertyLocation;

            const mapStyles = [{
                    featureType: "all",
                    elementType: "geometry",
                    stylers: [{
                        color: "#f5f5f5"
                    }]
                },
                {
                    featureType: "water",
                    elementType: "geometry",
                    stylers: [{
                        color: "#c9e9f6"
                    }]
                },
                {
                    featureType: "road",
                    elementType: "geometry",
                    stylers: [{
                        color: "#ffffff"
                    }]
                },
                {
                    featureType: "poi",
                    elementType: "labels",
                    stylers: [{
                        visibility: "off"
                    }]
                }
            ];

            function initializeMap() {
                const mapDiv = document.getElementById('map');
                if (!mapDiv || !window.google || !window.google.maps) return;

                const propertyAddress = "{{ $property->address }}";
                geocoder = new google.maps.Geocoder();

                geocoder.geocode({
                    address: propertyAddress
                }, function(results, status) {
                    if (status !== 'OK' || !results[0]) {
                        console.error('Geocoding error: ' + status);
                        return;
                    }

                    propertyLocation = results[0].geometry.location;
                    const initialCenter = {
                        lat: propertyLocation.lat(),
                        lng: propertyLocation.lng()
                    };

                    if (!mapInitialized) {
                        map = new google.maps.Map(mapDiv, {
                            center: initialCenter,
                            zoom: 15,
                            styles: mapStyles,
                            disableDefaultUI: true,
                            streetViewControl: true,
                            zoomControl: false,
                            mapTypeControl: false,
                            fullscreenControl: false,
                            gestureHandling: 'greedy'
                        });

                        propertyMarker = new google.maps.Marker({
                            map: map,
                            position: propertyLocation,
                            title: "{{ $property->propertyName }}",
                            animation: google.maps.Animation.DROP,
                            icon: {
                                path: google.maps.SymbolPath.CIRCLE,
                                scale: 12,
                                fillColor: "#dc3545",
                                fillOpacity: 1,
                                strokeColor: "#ffffff",
                                strokeWeight: 3
                            }
                        });

                        directionsService = new google.maps.DirectionsService();
                        directionsRenderer = new google.maps.DirectionsRenderer({
                            map: map,
                            polylineOptions: {
                                strokeColor: '#1e40af',
                                strokeWeight: 4
                            },
                            suppressMarkers: true
                        });

                        customDirectionsRenderer = new google.maps.DirectionsRenderer({
                            map: map,
                            polylineOptions: {
                                strokeColor: '#15803d',
                                strokeWeight: 4,
                                strokeOpacity: 0.8
                            },
                            suppressMarkers: true
                        });

                        setupCustomControls(initialCenter);
                        setupCustomRoute();
                        mapInitialized = true;
                    }

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            const userLocation = new google.maps.LatLng(
                                position.coords.latitude,
                                position.coords.longitude
                            );

                            userMarker = new google.maps.Marker({
                                map: map,
                                position: userLocation,
                                title: 'Your Location',
                                icon: {
                                    path: google.maps.SymbolPath.CIRCLE,
                                    scale: 12,
                                    fillColor: "#1e40af",
                                    fillOpacity: 1,
                                    strokeColor: "#ffffff",
                                    strokeWeight: 3
                                }
                            });

                            directionsService.route({
                                origin: userLocation,
                                destination: propertyLocation,
                                travelMode: 'DRIVING'
                            }, function(result, status) {
                                if (status === 'OK') {
                                    directionsRenderer.setDirections(result);
                                    showUserRouteInfo(result);

                                    const bounds = new google.maps.LatLngBounds();
                                    bounds.extend(userLocation);
                                    bounds.extend(propertyLocation);
                                    map.fitBounds(bounds, 50);
                                }
                            });
                        }, function() {
                            map.setCenter(initialCenter);
                            hideLoadingState();
                        });
                    } else {
                        map.setCenter(initialCenter);
                        hideLoadingState();
                    }
                });
            }

            function setupCustomControls(center) {
                const recenterBtn = document.getElementById('recenter-btn');
                const satelliteBtn = document.getElementById('satellite-toggle');
                const customRouteBtn = document.getElementById('custom-route-btn');

                if (recenterBtn) {
                    recenterBtn.addEventListener('click', () => {
                        map.setCenter(center);
                        map.setZoom(15);
                    });
                }

                if (satelliteBtn) {
                    satelliteBtn.addEventListener('click', () => {
                        isSatellite = !isSatellite;
                        map.setMapTypeId(isSatellite ? 'satellite' : 'roadmap');
                        satelliteBtn.querySelector('i').className = isSatellite ? 'bi bi-map' : 'bi bi-globe';
                    });
                }

                if (customRouteBtn) {
                    customRouteBtn.addEventListener('click', () => {
                        const panel = document.getElementById('custom-route-panel');
                        panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
                    });
                }
            }

            function setupCustomRoute() {
                const input = document.getElementById('custom-address-input');
                const panel = document.getElementById('custom-route-panel');
                const closeBtn = document.getElementById('close-route-panel');
                const submitBtn = document.getElementById('route-submit-btn');
                const clearBtn = document.getElementById('clear-route-btn');
                let selectedPlace = null;

                if (!input || !window.google || !window.google.maps) return;

                autocomplete = new google.maps.places.Autocomplete(input, {
                    componentRestrictions: {
                        country: 'ph'
                    },
                    types: ['geocode'],
                });

                autocomplete.addListener('place_changed', () => {
                    const place = autocomplete.getPlace();
                    if (!place.geometry) {
                        alert('Please select a valid address from the dropdown');
                        return;
                    }
                    selectedPlace = place;
                    submitBtn.disabled = false;
                });

                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        panel.style.display = 'none';
                    });
                }

                if (submitBtn) {
                    submitBtn.addEventListener('click', () => {
                        if (!selectedPlace) return;

                        const startLocation = selectedPlace.geometry.location;
                        clearBtn.style.display = 'block';

                        directionsService.route({
                            origin: startLocation,
                            destination: propertyLocation,
                            travelMode: 'DRIVING'
                        }, function(result, status) {
                            if (status === 'OK') {
                                customDirectionsRenderer.setDirections(result);
                                showCustomRouteInfo(result);

                                if (customMarker) customMarker.setMap(null);
                                customMarker = new google.maps.Marker({
                                    map: map,
                                    position: startLocation,
                                    title: 'Starting Point',
                                    icon: {
                                        path: google.maps.SymbolPath.CIRCLE,
                                        scale: 12,
                                        fillColor: "#15803d",
                                        fillOpacity: 1,
                                        strokeColor: "#ffffff",
                                        strokeWeight: 3
                                    }
                                });

                                const bounds = new google.maps.LatLngBounds();
                                bounds.extend(startLocation);
                                bounds.extend(propertyLocation);
                                map.fitBounds(bounds, 50);
                            }
                        });
                    });
                }

                if (clearBtn) {
                    clearBtn.addEventListener('click', () => {
                        customDirectionsRenderer.setDirections({
                            routes: []
                        });
                        if (customMarker) customMarker.setMap(null);
                        input.value = '';
                        selectedPlace = null;
                        submitBtn.disabled = true;
                        clearBtn.style.display = 'none';
                        hideCustomRouteInfo();
                    });
                }
            }

            function showUserRouteInfo(result) {
                const route = result.routes[0];
                if (!route || !route.legs[0]) return;

                const leg = route.legs[0];
                const routeInfo = document.getElementById('user-route-info');
                const routeDistance = document.getElementById('user-route-distance');
                const routeDuration = document.getElementById('user-route-duration');

                if (routeDistance) routeDistance.textContent = leg.distance.text;
                if (routeDuration) routeDuration.textContent = leg.duration.text;
                if (routeInfo) routeInfo.style.display = 'block';

                hideLoadingState();
            }

            function showCustomRouteInfo(result) {
                const route = result.routes[0];
                if (!route || !route.legs[0]) return;

                const leg = route.legs[0];
                const routeInfo = document.getElementById('custom-route-info');
                const routeDistance = document.getElementById('custom-route-distance');
                const routeDuration = document.getElementById('custom-route-duration');

                if (routeDistance) routeDistance.textContent = leg.distance.text;
                if (routeDuration) routeDuration.textContent = leg.duration.text;
                if (routeInfo) routeInfo.style.display = 'block';
            }

            function hideCustomRouteInfo() {
                const routeInfo = document.getElementById('custom-route-info');
                if (routeInfo) routeInfo.style.display = 'none';
            }

            function hideLoadingState() {
                const loadingState = document.getElementById('loading-state');
                if (loadingState) loadingState.style.display = 'none';
            }

            if (window.googleMapsReady) {
                initializeMap();
            } else {
                document.addEventListener('google-maps-ready', initializeMap);
            }
        })();
    </script>