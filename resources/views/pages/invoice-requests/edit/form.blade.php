<form id="invoice_form" method="post" action="#">
    <div class="row">
        <div class="col-lg-6">
            <div class="col-12">
                <label
                    for="inputNanme4"
                    class="form-label"
                    >Beat Name</label
                >
                <input type="text" name="beat_name" id="beat_name" disabled value="{{ $invoice_request->beat->beat_name }}" class="form-control">
                <input type="hidden" name="beat_id" id="beat_id" value="{{ $invoice_request->beat_id }}" class="form-control">                
            </div>
        </div>
        <div class="col-lg-6">
            <div class="col-12">
                <label
                    for="inputNanme4"
                    class="form-label"
                    >Select Customer</label
                >
                <input type="text" name="customer_name" id="customer_name" disabled value="{{ $invoice_request->customer->customer_name }}" class="form-control">
                <input type="hidden" name="customer_id" id="customer_id" value="{{ $invoice_request->customer_id }}" class="form-control">
            </div>
        </div>
        <div class="col-lg-12 mt-4">
            <div class="d-flex justify-content-between">
                <div>
                    <label
                        for="inputNanme4"
                        class="form-label"
                        >Select Products</label
                    >
                </div>
                <div class="d-flex">
                    <div class="form-check form-switch" style="margin-right: 13px">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="is_validation_active"
                            checked
                        />
                        <label
                            class="form-check-label"
                            for="is_validation_active"
                            >Is Rate Validation active</label
                        >
                    </div>
                    <button
                        class="btn btn-primary"
                        type="button"
                        onclick="showAddProductModal()"
                    >
                        Add Products
                    </button>
            
                </div>

            </div>

            @include('pages.invoice-requests.edit.product_table')
        
        </div>
    </div>
</form>