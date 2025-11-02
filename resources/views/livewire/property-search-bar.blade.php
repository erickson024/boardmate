<div class="container">
    <form
        class="search-bar d-flex align-items-center justify-content-between border border-dark bg-white shadow-sm rounded-pill px-3 py-2"
        style="max-width: 900px; margin: 0 auto;">

        <!-- Property Name -->
        <div class="px-3 flex-fill border-end search-field">
            <label for="propertyName" class="form-label fw-semibold mb-0 small text-dark">Property name</label>
            <input
                type="text"
                wire:model.live.debounce.150ms="propertyName"
                class="form-control border-0 shadow-none p-0 fw-medium"
                id="propertyName"
                placeholder="e.g. Cozy Stay"
                autocomplete="off">
        </div>

        <!-- Cost Cap -->
        <div class="px-3 flex-fill border-end search-field">
            <label for="costCap" class="form-label fw-semibold mb-0 small text-dark">Cost cap</label>
            <input
                type="number"
                wire:model.live.debounce.150ms="costCap"
                class="form-control border-0 shadow-none p-0 fw-medium"
                id="costCap"
                placeholder="Set your price limit"
                autocomplete="off">
        </div>

        <!-- Location -->
        <div class="px-3 flex-fill border-end search-field">
            <label for="location" class="form-label fw-semibold mb-0 small text-dark">Location</label>
            <input
                type="text"
                wire:model.live.debounce.150ms="location"
                class="form-control border-0 shadow-none p-0 fw-medium small"
                id="location"
                placeholder="Search destination"
                autocomplete="off">
        </div>

        <!-- Property Type -->
        @php
        $propertyTypes = ['Apartment', 'Room', 'Bedspace', 'Studio', 'Condominium'];
        @endphp
        <div class="px-3 flex-fill search-field">
            <label for="propertyType" class="form-label fw-semibold mb-0 small text-dark">Type</label>
            <select
                id="propertyType"
                wire:model.live="propertyType"
                class="form-select border-0 shadow-none p-0 fw-medium bg-transparent type-select">
                <option value="">Any</option>
                @foreach($propertyTypes as $type)
                <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <!-- Filter Button -->
        <div class="ps-3 search-btn">
            <button class="btn btn-dark rounded-circle d-flex align-items-center justify-content-center"
                type="button" style="width: 44px; height: 44px;"
                data-bs-toggle="modal" data-bs-target="#sort">
                <i class="bi bi-sliders2"></i>
            </button>
        </div>
    </form>

    <style>
        form:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.2s ease-in-out;
        }

        input:focus,
        select:focus {
            background-color: #f8f9fa;
        }

        /* Normal responsiveness (tablet) */
        @media (max-width: 992px) {
            .search-bar {
                flex-wrap: wrap;
                border-radius: 1.5rem;
                padding: 1rem;
            }

            .search-field {
                border: none !important;
                width: 50%;
                margin-bottom: 0.75rem;
            }

            .search-btn {
                width: 100%;
                display: flex;
                justify-content: center;
                padding-top: 0.5rem;
            }
        }

        /* ✅ MOBILE: Only Property Name + Filter Button side-by-side */
        @media (max-width: 576px) {
            .search-bar {
                border-radius: 50px;
                padding: 0.4rem 0.75rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: nowrap;
                gap: 0.5rem;
            }

            /* Hide everything except Property Name */
            .search-field:not(:first-child) {
                display: none !important;
            }

            /* Property Name Field */
            .search-field:first-child {
                border: none !important;
                flex: 1;
                display: flex;
                align-items: center;
                margin: 0;
                padding: 0;
            }

            .search-field:first-child label {
                display: none; /* hide label for compact layout */
            }

            .search-field:first-child input {
                width: 100%;
                font-size: 0.9rem;
                border: none;
                outline: none;
                box-shadow: none;
                padding: 0.4rem;
            }

            /* Filter Button */
            .search-btn {
                flex-shrink: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0;
                padding: 0;
            }

            .search-btn button {
                width: 40px;
                height: 40px;
            }
        }

        /* Placeholder text */
        .search-bar ::placeholder {
            font-size: 0.8rem;
            color: #adb5bd;
        }

        /* Dropdown style */
        .type-select,
        .type-select option {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .type-select {
            background-image: none !important;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-color: transparent;
            padding-right: 1rem;
            position: relative;
        }

        .type-select:focus {
            background-color: #f8f9fa;
            outline: none;
            box-shadow: none;
        }
    </style>
</div>
