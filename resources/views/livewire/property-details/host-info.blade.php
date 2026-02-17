<div class="row  vh-100 d-flex align-items-center section property-host">
    <div class="col-12 ">
        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <div class="text-center mb-3">
                    <p class="fw-medium fs-5 mb-0">Get In Touch</p>
                    <div class="text-muted mb-0">
                        <p class="mb-0"><small>Interested in this property?</small></p>
                        <p class="mb-0"><small> Contact the host directly for more information or click Inquire to schedule a visit.</small></p>
                    </div>
                </div>
                <!-- Contact Card Component -->
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <div class="col-4">
                            {{-- Host card stays the same --}}
                            <x-host-contact-card :user="$property->user" :property="$property" :showInquire="true" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>