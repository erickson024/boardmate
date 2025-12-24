<div>
    <p class="fs-6 fw-medium mb-3">
        Select the features that apply to your property to highlight its amenities.
    </p>

    <div class="d-flex flex-wrap gap-2">
        @php
        $features = [
        'WiFi' => 'wifi',
        'Microwave' => 'microwave',
        'Rice Cooker' => 'cup-hot',
        'Television' => 'tv',
        'Refrigerator' => 'fridge',
        'Shower' => 'shower',
        'Water Heater' => 'thermometer-half',
        'Electric Fan' => 'wind',
        'Air-condition' => 'snow',
        'Washing Machine' => 'gear',
        'Iron & Ironing Board' => 'tools',
        'Stove' => 'fire',
        'Near Store' => 'shop',
        'Near Public Transport' => 'bus-front',
        'Near Schools' => 'school',
        'Near Market' => 'basket',
        'Parking Space' => 'car-front',
        'Swimming Pool' => 'water',
        'Study Area' => 'book',
        'Lounge' => 'chat-square-text',
        'Security Personnel' => 'shield-lock',
        'CCTV' => 'camera-video',
        'Gated Property' => 'door-closed',
        'Smart Lock Access' => 'fingerprint',
        'Fully Furnished' => 'house-fill',
        'Pets Friendly' => 'paw',
        'Elevator Access' => 'box-arrow-up',
        'Rooftop' => 'sun',
        'Kitchen Access' => 'cup-straw',
        ];
        @endphp

        @foreach ($features as $label => $icon)
        <button
            type="button"
            wire:key="feature-{{ $label }}"
            wire:click="toggleFeature('{{ $label }}')"
            class="btn btn-outline-dark btn-sm {{ in_array($label, $feature) ? 'btn-dark text-white' : '' }}">
            <i class="bi bi-{{ $icon }} me-1"></i>{{ $label }}
        </button>
        @endforeach

    </div>

    <input type="hidden" name="selected_features" wire:model="feature" id="selected_features" />

    <form wire:submit.prevent="submit" class="mt-4 d-flex justify-content-between">
        <button type="button" class="btn btn-sm btn-outline-dark" wire:click="back">
            <span class="fw-semibold small">Back</span>
            <span wire:loading wire:target="back">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </span>
        </button>
        <button type="submit" class="btn btn-sm btn-dark">
            <span class="fw-semibold small">Continue</span>
            <span wire:loading wire:target="submit">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </span>
        </button>
    </form>
</div>