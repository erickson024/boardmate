    <div class="row vh-100 d-flex align-items-center  section">
        <div class="col-12 border-top border-bottom h-20">
            <div class="row py-5">
                <!-- property cost -->
                <div class="col-3 d-flex justify-content-center">
                    <div class="text-start">
                        <p class="fs-5 fw-medium mb-0"> ₱{{ number_format($property->propertyCost, 0) }} </p>
                        <p class="text-muted mb-0"> <small>Monthly Wage</small> </p>
                    </div>
                </div>

                <!-- property type -->
                <div class="col-3 d-flex flex-column align-items-center">
                    <div class="text-start">
                        <p class="fs-5 fw-medium mb-0"> {{ ucfirst($property->propertyType) }}</p>
                        <p class="text-muted mb-0"><small>Residence Type</small></p>
                    </div>
                </div>

                <!-- tenant type -->
                <div class="col-3  d-flex flex-column align-items-center">
                    <div class="text-start">
                        <p class="fs-5 fw-medium mb-0">{{ucfirst($property->tenantType) }}</p>
                        <p class="text-muted mb-0"><small>Ideal For</small></p>
                    </div>
                </div>

                <!-- tenant gender -->
                <div class="col-3  d-flex flex-column align-items-center">
                    <div class="text-start">
                        <p class="fs-5 fw-medium mb-0">{{ucfirst($property->tenantGender) }} Gender</p>
                        <p class="text-muted mb-0"><small>Preferred Occupant</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>