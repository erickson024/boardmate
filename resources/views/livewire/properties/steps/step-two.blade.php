<div>
    <div class="row">
        <div class="col-12">

            <input type="hidden" id="latitude" wire:model="latitude">
            <input type="hidden" id="longitude" wire:model="longitude">
           
                
                <!-- Input on top of map -->
                <div wire:key="field-address"
                    class=""
                    style="width: 100%; z-index: 10;">

                    <div class="input-group shadow">
                        <span class="input-group-text bg-white text-white border-0 px-3">
                            <i class="bi bi-geo-alt-fill text-dark"></i>
                        </span>
                        <input
                            type="text"
                            class="form-control text-dark shadow-none fw-semibold border-0 p-3"
                            placeholder="Enter your address"
                            id="address-input"
                            wire:model="address"
                            style="font-size: 13px;"
                            autocomplete="off"
                            aria-describedby="basic-addon1">
                    </div>
                    @error('address')
                    <small class="text-danger d-block mt-1 bg-white p-2 rounded" style="font-size: 13px;">{{ $message }}</small>
                    @enderror
                </div>
       
        </div>
    </div>
</div>