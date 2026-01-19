<div class="container-fluid mt-5">
    <div class="row">

        <div class="col-12 col-md-6">
            <div class="success-section d-flex align-items-center justify-content-center mt-4">
                <div class="w-100 " style="max-width: 480px;">
                    <div class="glass-card p-4 ">
                        <!-- Success Icon & Header -->
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="success-icon-wrapper">
                                <i class="bi bi-check2"></i>
                            </div>
                            <div>
                                <h4 class="fw-semibold mb-1" style="font-size: 1.125rem; color: #0f172a;">Property Created Successfully</h4>
                                <p class="mb-0" style="font-size: 0.875rem; color: #64748b;">Review your property details below</p>
                            </div>
                        </div>

                        <!-- Property Info Card -->
                        <div class="property-info-card mb-3">
                            <h6 class="fw-semibold mb-1" style="font-size: 0.9375rem; color: #1e293b;">{{$property->propertyName}}</h6>
                            <p class="mb-0" style="font-size: 0.8125rem; color: #64748b;">{{$property->address}}</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row g-2 mb-3">
                            <div class="col-12">
                                <button class="btn btn-sm btn-dark w-100 fw-medium">
                                    <small>
                                        <i class="bi bi-eye me-2"></i>
                                        View Details
                                    </small>
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-sm btn-outline-dark w-100">
                                    <small>
                                        <i class="bi bi-list-ul me-2"></i>
                                        Property List
                                    </small>
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-sm btn-outline-dark w-100 ">
                                    <small>
                                        <i class="bi bi-plus-circle me-2"></i>
                                        Add Property
                                    </small>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .success-section {}

        .glass-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }

        .success-icon-wrapper {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.25);
            animation: scaleIn 0.4s ease-out;
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .success-icon-wrapper i {
            font-size: 1.75rem;
            color: white;
        }

        .property-info-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            padding: 1.25rem;
            transition: all 0.3s ease;
        }

        .property-info-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .stats-item {
            padding: 0.75rem;
            border-radius: 8px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .stats-item:hover {
            background: white;
            border-color: #cbd5e1;
        }
    </style>
</div>