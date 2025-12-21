<div class="container">
  <div class="row">
    <div class="col-12 d-flex justify-content-center align-items-center min-vh-100">
        <div class="p-4 border rounded-3 bg-light">
            <p class="fs-4 fw-medium"> <span class="">Hello {{auth()->user()->firstName}}, </span> You are now a verified Host!</p>
       
            <p class="mb-3">
            Thank you for choosing to be a host on our platform. 
            </p>

            <button class="btn btn-sm btn-dark">
                <span class="fw-semibold small">boardmate home</span>
            </button>

            <button class="btn btn-sm btn-outline-dark">
                <span class="fw-semibold small">register a property</span>
            </button>
        </div>
    </div>
  </div>
</div>
