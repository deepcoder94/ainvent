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
                    class="form-select"
                    onchange="getCustomers(event)"
                >
                    <option value="">Choose...</option>
                    @foreach ($beats as $b)
                    <option value="{{ $b->id }}">
                        {{ $b->beat_name }}
                    </option>
                    @endforeach
                </select>
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
                    class="form-select"
                    name="customer_id"
                >
                    <option value="">Choose...</option>
                </select>
                <input
                    type="hidden"
                    id="customers"
                    value="{{ $customers }}"
                />
                <input
                    type="hidden"
                    id="products"
                    value="{{ $products }}"
                />
                <input
                    type="hidden"
                    id="measurements"
                    value="{{ $measurements }}"
                />
                <input
                    type="hidden"
                    id="store_url"
                    value="{{
                        route('newInvoiceCreate')
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
                <div>
                    <button
                        class="btn btn-primary"
                        type="button"
                        onclick="showAddProductModal()"
                    >
                        Add Products
                    </button>
                </div>
            </div>

            @include('pages.invoices.product_table')
        
        </div>
    </div>
</form>