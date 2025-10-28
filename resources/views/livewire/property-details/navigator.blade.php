<div class="container-fluid py-4">
    <div class="row g-4">
        <!-- Sidebar Navigation -->
        <div class="col-12 col-md-3">
            @php
            $tabs = [
            'overview' => ['title' => 'Overview', 'desc' => 'General property info'],
            'images' => ['title' => 'Images', 'desc' => 'View property photos'],
            'map' => ['title' => 'Map', 'desc' => 'See location on map'],
            'host' => ['title' => 'Host', 'desc' => 'Contact information'],
            ];
            @endphp

            <div class="sticky-top " style="top: 90px;">
                @foreach($tabs as $tab => $info)
                @php
                $isActive = $active === $tab;
                $btnClass = 'btn text-start p-3 rounded-3 w-100 bg-transparent border-0';
                if ($isActive) {
                // active styling: light bg + left indicator + subtle shadow
                $btnClass .= ' active-tab';
                }
                @endphp

                <button type="button"
                    wire:click="setTab('{{ $tab }}')"
                    class="{{ $btnClass }} d-flex justify-content-start"
                    wire:loading.class="loading">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <div class="fw-medium mb-1">{{ $info['title'] }}</div>
                            <small class="text-secondary d-none d-md-block">{{ $info['desc'] }}</small>
                        </div>

                        {{-- Spinner that shows only when this specific tab is loading --}}
                        <div wire:loading wire:target="setTab('{{ $tab }}')"
                            class="spinner-wrapper">
                            <span class="spinner-border spinner-border-sm"></span>
                        </div>
                    </div>
                </button>
                @endforeach
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-md-9">
            @if ($active === 'overview')
            <livewire:property-details.overview :propertyId="$propertyId" />
            @elseif ($active === 'images')
            <livewire:property-details.images :propertyId="$propertyId" />
            @elseif ($active === 'map')
            <livewire:property-details.mappings :propertyId="$propertyId" />
            @elseif ($active === 'host')
            <livewire:property-details.host :propertyId="$propertyId" />
            @endif
        </div>
    </div>

    <style>
        /* remove default focus flash but keep keyboard accessibility */
        button:focus {
            outline: none !important;
        }

        /* Active tab visual */
        .active-tab {
            background-color: #f8f9fa;
            /* subtle light background */
            position: relative;
        }

        /* left colored indicator */
        .active-tab::before {
            content: "";
            position: absolute;
            left: 0;
            top: 8px;
            bottom: 8px;
            width: 4px;
            background: #212529;
            /* Laravel dark color */
            border-radius: 2px;
        }

        /* Hover effect for non-active items */
        button:not(.active-tab):hover {
            background-color: ;
        }

        /* Keep the spinner aligned nicely */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* If your container has overflow clipping, show left indicator above */
        .col-md-3 {
            overflow: visible;
        }

        .loading {
            opacity: 0.7;
            cursor: wait;
        }

        .spinner-wrapper {
            position: absolute;
            right: 1rem;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 2px;
            color: #6c757d;
        }

        /* Make button position relative for absolute spinner positioning */
        .btn {
            position: relative;
        }
    </style>
</div>