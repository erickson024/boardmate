<div>
    <p class="fs-6 fw-semibold">Provide the basic information about your property so tenants know what you offer.</p>

    <form wire:submit.prevent="submit">
        <div class="row">
            <div class="col-6">
                <x-inputs.floating-input
                    id="name"
                    label="Property Name"
                    type="text"
                    model="name" />
            </div>

            <div class="col-6">
                <div class="form-floating">
                    <x-inputs.floating-input
                        id="cost"
                        label="Property Cost"
                        type="number"
                        model="cost" />
                </div>
            </div>

            <div class="col-6">
                <!--Property Type-->
                @php
                $propertyTypes = ['Apartment', 'Condominium', 'Dormitory', 'Studio', 'Bedspace', 'House'];
                @endphp

                <div class="form-floating">
                    <select
                        wire:model="type"
                        class="form-select shadow-sm select"
                        placeholder="property type"
                        id="propertyType"
                        required>
                        @foreach ($propertyTypes as $type)
                        <option value="{{$type}}" class="option">{{$type}}</option>
                        @endforeach
                    </select>
                    <label for="propertyType" class="fw-semibold"><small>Property Type</small></label>
                </div>
            </div>

            <div class="col-12 mt-3">
                <div class="form-floating">
                    <textarea
                        class="form-control border-1 shadow-sm font-property"
                        wire:model="description"
                        placeholder="description"
                        id="description"
                        style="height: 100px"
                        required></textarea>
                    <label for="description" class="fw-semibold"><small>Description</small></label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-sm btn-dark mt-3">
            <span class="fw-semibold small">Continue</span>

            <span wire:loading wire:target="submit">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </span>
        </button>
    </form>

    <style>
        .select {
            font-size: 14px;
            font-weight: 500;
        }

        .option {
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</div>