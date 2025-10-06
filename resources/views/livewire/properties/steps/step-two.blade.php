<div>
    <div class="row gx-3">
        <div class="col-6">
            <div class="form-floating">
                <input
                    type="text"
                    class="form-control border-dark text-dark shadow-none"
                    placeholder="Property Name"
                    wire:model="name">
                <label class="text-dark">Property Name</label>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="col-6">
            <div class="form-floating">
                <select
                    class="form-select border-dark text-dark shadow-none"
                    id="type"
                    aria-label="Floating label select example"
                    wire:model="type">
                    <option value="" selected disabled>Open this select menu</option>
                    <option value="room">Room</option>
                    <option value="bedspace">Bedspace</option>
                    <option value="apartment">Apartment</option>
                    <option value="condo">Condo</option>
                    <option value="house">House</option>
                </select>
                <label for="floatingSelect">Property Type</label>
                @error('type') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
    </div>

    <div class="row gx-3 mt-3">
        <div class="col-6">
            <div class="form-floating " wire:key="field-address">
                <input
                    type="number"
                    class="form-control border-dark text-dark shadow-none"
                    placeholder="cost"
                    wire:model="cost">
                <label class="text-dark">Monthly Cost</label>
                @error('cost') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="col-6">
            <div class="form-floating">
                <select
                    class="form-select border-dark text-dark shadow-none"
                    id="tenant"
                    aria-label="Floating label select example"
                    wire:model="tenant">
                    <option value="" disabled>Open this select menu</option>
                    <option value="student">Student</option>
                    <option value="professional">Professional</option>
                    <option value="family">Family</option>
                    <option value="any">Any</option>
                </select>
                <label for="floatingSelect">Tenant Type</label>
                @error('tenant') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="form-floating">
                <textarea
                    class="form-control border-dark text-dark shadow-none "
                    placeholder="Leave a comment here"
                    id="floatingTextarea2"
                    style="height: 100px"
                    wire:model="description"></textarea>
                <label for="floatingTextarea2" class="text-dark">Property Description</label>
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>
    </div>

</div>



