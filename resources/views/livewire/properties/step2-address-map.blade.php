<div>

    <div class="mb-3">
        <label class="form-label fw-semibold">Property Address</label>
        <input
            id="autocomplete"
            type="text"
            class="form-control"
            wire:model.defer="address"
            placeholder="Search address"
        >
    </div>

    <div wire:ignore class="mb-3">
        <div id="map" style="height:350px;border-radius:8px;"></div>
    </div>

    <form wire:submit.prevent="submit" class="d-flex justify-content-between">
        <button type="button" class="btn btn-outline-dark btn-sm" wire:click="back">Back</button>
        <button type="submit" class="btn btn-dark btn-sm">Continue</button>
    </form>

    @push('scripts')
    <script>
        let map, marker, autocomplete;

        function initStep2Map(lat, lng) {
            const center = { lat: parseFloat(lat), lng: parseFloat(lng) };

            map = new google.maps.Map(document.getElementById('map'), {
                center,
                zoom: 15
            });

            marker = new google.maps.Marker({
                map,
                position: center,
                draggable: true
            });

            marker.addListener('dragend', () => {
                const pos = marker.getPosition();
                Livewire.dispatch('setAddress', [
                    document.getElementById('autocomplete').value,
                    pos.lat(),
                    pos.lng()
                ]);
            });

            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('autocomplete')
            );

            autocomplete.addListener('place_changed', () => {
                const place = autocomplete.getPlace();
                if (!place.geometry) return;

                const loc = place.geometry.location;
                map.setCenter(loc);
                marker.setPosition(loc);

                Livewire.dispatch('setAddress', [
                    place.formatted_address,
                    loc.lat(),
                    loc.lng()
                ]);
            });
        }

        window.addEventListener('init-step2-map', e => {
            setTimeout(() => {
                initStep2Map(e.detail.lat, e.detail.lng);
            }, 150);
        });
    </script>
    @endpush
    
 
</div>