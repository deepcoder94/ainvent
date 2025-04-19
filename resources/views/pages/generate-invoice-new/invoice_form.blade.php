<form id="invoice_form" method="post" action="#">
    <div class="row">
        <div class="col-lg-6">
            <div class="col-12">
                <label
                    for="inputNanme4"
                    class="form-label"
                    >Select Beat</label
                >
                <select
                    id="beat_id"
                    name="beat_id"
                    class="form-select sel2input"
                    onchange="getCustomers(event)"
                >
                    <option value="">Choose...</option>
                    @foreach ($beats as $b)
                    <option value="{{ $b->id }}">
                        {{ $b->beat_name }}
                    </option>
                    @endforeach
                </select>
                <div class="invalid-feedback" id="invalid_beat" style="display: none"></div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="col-12">
                <label
                    for="inputNanme4"
                    class="form-label"
                    >Select Customer</label
                >
                <select
                    id="customer_id"
                    class="form-select sel2input"
                    name="customer_id"
                    onchange="clearInputErrors('invalid_customer')"
                >
                    <option value="">Choose...</option>
                </select>
                <div class="invalid-feedback" id="invalid_customer" style="display: none"></div>

                <input
                    type="hidden"
                    id="store_url"
                    value="{{
                        route('newInvoiceCreate2')
                    }}"
                />
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

            @include('pages.generate-invoice-new.product_table')
        
        </div>
    </div>
</form>