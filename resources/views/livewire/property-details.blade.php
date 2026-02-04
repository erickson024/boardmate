<div class="vh-100 property-details" style="overflow: hidden;">

    <div class="scroll-wrapper" id="scrollWrapper">
        <div class="container">

            <!-- property name, address, description and property images -->
            <div class="section" data-section="0">
                <livewire:property-details.basic-info :property="$property" />
            </div>

            <!-- cost, propertyType, tenantType, gender -->
            <div class="section" data-section="1">
                <livewire:property-details.tenant-info :property="$property" />
            </div>

            <!-- property location -->
            <div class="section" data-section="2">
                <livewire:property-details.property-location :property="$property" />
            </div>

            <!-- property feature -->
            <div class="section" data-section="3">
                <livewire:property-details.property-feature :property="$property" />
            </div>

            <!-- property restriction -->
            <div class="section" data-section="4">
                <livewire:property-details.property-restriction :property="$property" />
            </div>

            <!-- host info -->
            <div class="section" data-section="5">
                <livewire:property-details.host-info :property="$property" />
            </div>
        </div>
    </div>
</div>