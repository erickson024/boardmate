<div>
    <div class="row">
        <div class="col-12 mb-3">
            <label class="fw-semibold">Terms and condition for Tenants</label>
            <small class="text-muted d-block">
                Define the terms and conditions that tenants must follow when renting or staying at your property.
                These will be shown to tenants before they proceed with a booking or rental.
            </small>
        </div>
        <div class="col-12">
            <x-floating-labels.text-area
                id="terms"
                height="250"
                label="Write your terms and conditions here."
                wire:model="terms" />
        </div>
    </div>
</div>