<div class="container-fluid bg-primary mt-5">
    <div class="row bg-primary">
        <div class="col-6">
            <livewire:property-details.images :property="$property" />
        </div>
        <div class="col-6 bg-warning">
           <livewire:property-details.maps :property="$property" />
        </div>
    </div>
</div>