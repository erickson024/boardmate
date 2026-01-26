<div class="row vh-100 d-flex align-items-center section location-details">
    <div class="col-12 col-md-6">
        <div class="d-flex flex-row gap-2 mb-4">
            <div class="bg-dark d-flex align-items-center rounded text-light py-2 px-3">
                <i class="bi bi-geo-alt"></i>
            </div>

            <div class="">
                <p class="fw-medium fs-5 mb-0">{{ $property->propertyName }} Routes</p>
                <small class="text-muted mb-0">{{ $property->address }}</small>
            </div>
        </div>

        <!-- Wrapper with position-relative for the floating panel -->
        <div class="position-relative property-map-details">
            <!-- Route Visualization -->
            <div class="mb-4">
                <div class="d-flex align-items-start" style="gap: 12px;">
                    <div class="d-flex flex-column align-items-center" style="gap: 6px; padding-top: 4px;">
                        <div class="rounded-circle" style="width: 10px; height: 10px; background-color: #1e40af; border: 2px solid #dbeafe;"></div>
                        <div style="width: 2px; height: 70px; background: repeating-linear-gradient(to bottom, #cbd5e1 0, #cbd5e1 4px, transparent 4px, transparent 8px);"></div>
                        <div class="rounded-circle" style="width: 10px; height: 10px; background-color: #dc2626; border: 2px solid #fee2e2;"></div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="mb-5">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <p class="mb-0 fw-semibold" style="color: #1e293b; font-size: 13px;">
                                    <i class="bi bi-cursor-fill" style="color: #1e40af; font-size: 12px;"></i>
                                    Starting Point
                                </p>
                                <button
                                    id="change-starting-point-btn"
                                    class="btn btn-sm btn-outline-dark d-flex align-items-center gap-1"
                                    style="padding: 4px 10px; font-size: 11px; border-radius: 6px;">
                                    <i class="bi bi-pencil" style="font-size: 10px;"></i>
                                    Change
                                </button>
                            </div>
                            <p class="mb-0" id="user-route-from" style="color: #64748b; font-size: 12px; line-height: 1.6; padding-left: 20px;">
                                <i class="bi bi-hourglass-split" style="font-size: 11px;"></i> Calculating your location...
                            </p>
                        </div>
                        <div>
                            <p class="mb-1 fw-semibold" style="color: #1e293b; font-size: 13px;">
                                <i class="bi bi-house-fill" style="color: #dc2626; font-size: 12px;"></i>
                                Destination
                            </p>
                            <p class="mb-0" id="user-route-to" style="color: #64748b; font-size: 12px; line-height: 1.6; padding-left: 20px;">
                                {{ $property->address }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Custom Starting Point Panel (Floating overlay - positioned absolutely within this wrapper) -->
            <div id="custom-starting-point-panel" class="p-4 rounded-3 border position-absolute" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); display: none; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(0, 0, 0, 0.05); border-color: #e2e8f0; z-index: 1000; top: 0; left: 0; right: 0;">

                <!-- Header -->
                <div class="d-flex align-items-center justify-content-between mb-3 position-relative" style="z-index: 1001;">
                    <h6 class="mb-0 fw-semibold d-flex align-items-center gap-2" style="color: #1e293b; font-size: 14px;">
                        <span class="d-flex align-items-center justify-content-center rounded-circle" style="width: 32px; height: 32px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); box-shadow: 0 2px 8px rgba(30, 64, 175, 0.15);">
                            <i class="bi bi-pin-map-fill" style="color: #1e40af; font-size: 14px;"></i>
                        </span>
                        Set Custom Starting Point
                    </h6>
                    <button id="close-custom-panel" class="btn btn-sm btn-link text-muted p-0 d-flex align-items-center justify-content-center rounded-circle" style="text-decoration: none; width: 28px; height: 28px; transition: all 0.2s ease; background-color: #f1f5f9;">
                        <i class="bi bi-x-lg" style="font-size: 12px;"></i>
                    </button>
                </div>

                <!-- Search Input -->
                <div class="input-group mb-3 position-relative" style="z-index: 1002;">
                    <span class="input-group-text bg-dark d-flex align-items-center justify-content-center" style="border-right: none; border-color: #000000; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);">
                        <i class="bi bi-search" style="color: #ffffff; font-size: 14px;"></i>
                    </span>
                    <input
                        type="text"
                        id="custom-starting-point-input"
                        class="form-control"
                        placeholder="Search for an address or place..."
                        style="border-left: none; font-size: 13px; border-color: #e2e8f0; box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05); padding: 10px 12px;">
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 mb-2 position-relative" style="z-index: 1001;">
                    <button id="use-current-location-btn" class="btn btn-sm btn-outline-dark flex-fill d-flex align-items-center justify-content-center gap-2" style="padding: 10px 16px; font-size: 12px; font-weight: 600; border-radius: 8px; transition: all 0.2s ease;">
                        <i class="bi bi-crosshair" style="font-size: 14px;"></i>
                        <span>Current Location</span>
                    </button>
                    <button id="apply-custom-starting-point" class="btn btn-sm btn-dark flex-fill d-flex align-items-center justify-content-center gap-2" style="padding: 10px 16px; font-size: 12px; font-weight: 600; border-radius: 8px; transition: all 0.2s ease;" disabled>
                        <i class="bi bi-check-lg" style="font-size: 14px;"></i>
                        <span>Apply Route</span>
                    </button>
                </div>

                <!-- Reset Button -->
                <button id="reset-to-current-location" class="btn btn-sm btn-link text-danger w-100 d-flex align-items-center justify-content-center gap-2 position-relative" style="display: none !important; font-size: 12px; font-weight: 600; padding: 8px; text-decoration: none; z-index: 1001; transition: all 0.2s ease;">
                    <i class="bi bi-arrow-counterclockwise" style="font-size: 13px;"></i>
                    <span>Reset to My Location</span>
                </button>

                <!-- Decorative Background Element -->
                <div class="position-absolute rounded-circle" style="width: 100px; height: 100px; background: radial-gradient(circle, rgba(30, 64, 175, 0.05) 0%, transparent 70%); top: -20px; right: -20px; z-index: 0; pointer-events: none;"></div>
            </div>
        </div>

        <!-- Route Statistics (outside the position-relative wrapper so it doesn't get covered) -->
        <div class="d-flex gap-3 mb-4 p-3 rounded-3">
            <div class="flex-fill text-center">
                <div class="mb-1">
                    <i class="bi bi-speedometer2" style="color: #64748b; font-size: 20px;"></i>
                </div>
                <p class="mb-0 fw-semibold" id="user-route-distance" style="color: #1e293b; font-size: 14px;">--</p>
                <p class="mb-0 text-muted" style="font-size: 11px;">Distance</p>
            </div>
            <div class="flex-fill text-center" style="border-left: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0;">
                <div class="mb-1">
                    <i class="bi bi-clock-fill" style="color: #64748b; font-size: 20px;"></i>
                </div>
                <p class="mb-0 fw-semibold" id="user-route-duration" style="color: #1e293b; font-size: 14px;">--</p>
                <p class="mb-0 text-muted" style="font-size: 11px;">Duration</p>
            </div>
            <div class="flex-fill text-center">
                <div class="mb-1">
                    <i class="bi bi-car-front-fill" style="color: #64748b; font-size: 20px;"></i>
                </div>
                <p class="mb-0 fw-semibold" style="color: #1e293b; font-size: 14px;">Driving</p>
                <p class="mb-0 text-muted" style="font-size: 11px;">Mode</p>
            </div>
        </div>
    </div>

    <div class="col-6 h-100 d-flex align-items-center">
        <div
            id="map"
            class="rounded-4"
            style="height: 80%; width: 100%;"
            data-property-address="{{ $property->address }}"
            data-property-name="{{ $property->propertyName }}"></div>
    </div>
</div>