<div>
    <p class="fs-6 fw-semibold">Provide the basic information about your property so tenants know what you offer.</p>

    <form wire:submit.prevent="submit">
        <div class="row g-3">
            <div class="col-6">
                <div class="form-floating">
                    <input 
                    type="text" 
                    wire:model="name"
                    class="form-control border-1 shadow-sm font-property" 
                    placeholder="property name" 
                    required>
                    <label><small>Property Name</small></label>
                </div>
            </div>

            <div class="col-6">
                <div class="form-floating">
                    <input 
                    type="number"
                    wire:model="cost" 
                    class="form-control border-1 shadow-sm font-property" 
                    placeholder="property cost" 
                    required>
                    <label><small>Property Cost</small></label>
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
                    class="form-select shadow-sm font-property" 
                    id="floatingSelectGrid" 
                    required>
                        @foreach ($propertyTypes as $type)
                        <option value="{{$type}}">{{$type}}</option>
                        @endforeach
                    </select>
                    <label for="floatingSelectGrid"><small>Property Type</small></label>
                </div>
            </div>

            <div class="col-12">
                <div class="form-floating">
                    <textarea 
                    class="form-control border-1 shadow-sm font-property" 
                    wire:model="description"
                    placeholder="Leave a comment here" 
                    id="floatingTextarea2" 
                    style="height: 100px" 
                    required></textarea>
                    <label for="floatingTextarea2"><small>Description</small></label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-sm btn-dark mt-3">
            <span>Continue</span>

            <span wire:loading wire:target="submit">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </span>
        </button>


    </form>
</div>