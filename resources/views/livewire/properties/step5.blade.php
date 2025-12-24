<div class="w-100">
    <p class="fs-6 fw-semibold">Specify the type of tenants your property is suitable for.</p>

    <form wire:submit.prevent="submit">

        <div class="row g-3">
            <div class="col-6">
                @php
                $tenant = ['Employee', 'Student', 'Family', 'Groups', 'Single', 'Couple', 'Any'];
                @endphp
                <div class="form-floating">
                    <select
                        wire:model="tenantType"
                        class="form-select shadow-sm font-property"
                        id="floatingSelectGrid"
                        required>
                        @foreach ($tenant as $tenantType)
                        <option value="{{$tenantType}}">{{$tenantType}}</option>
                        @endforeach
                    </select>
                    <label for="floatingSelectGrid" class="fw-semibold"><small>Target Tenant</small></label>
                </div>
                @error('tenantType') <div class="text-danger"><small>{{ $message }}</small></div> @enderror
            </div>

            <div class="col-6">
                @php
                $gender = ['Male', 'Female', 'Any'];
                @endphp
                <div class="form-floating">
                    <select
                        wire:model="tenantGender"
                        class="form-select shadow-sm font-property"
                        id="floatingSelectGrid"
                        required>
                        @foreach ($gender as $tenantGender)
                        <option value="{{$tenantGender}}">{{$tenantGender}}</option>
                        @endforeach
                    </select>
                    <label for="floatingSelectGrid" class="fw-semibold"><small>Preferred Gender</small></label>
                </div>
                @error('tenantGender') <div class="text-danger"><small>{{ $message }}</small></div> @enderror
            </div>

              <div class="col-12">
                <div class="form-floating">
                    <textarea 
                    class="form-control border-1 shadow-sm font-property" 
                    wire:model="tenantRestriction"
                    placeholder="Leave a comment here" 
                    id="floatingTextarea2" 
                    style="height: 100px" 
                    ></textarea>
                    <label for="floatingTextarea2" class="fw-semibold"><small>Type your restriction</small></label>
                </div>
                 @error('tenantRestriction') <div class="text-danger"><small>{{ $message }}</small></div> @enderror
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
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
        </div>
    </form>
</div>