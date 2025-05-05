<x-layout :currentPage="$currentPage">
    
    <div id="customerPage" style="display:none">

    <div>
        <button class="btn btn-primary mt-2 mb-2" onclick="showCreateForm()">
            Add New
        </button>
        <button class="btn btn-dark mt-2 mb-2" onclick="startBulkUpload()">
            <i class="bi bi-upload me-1"></i> Upload Bulk
        </button>        
        <input type="file" id="csv-file" accept=".csv, .txt" style="display: none" onchange="uploadBulk()" />
        <button class="btn btn-warning mt-2 mb-2" onclick="exportCustomers()">
            <i class="bi bi-download me-1"></i> Export 
        </button>        

        <div style="float: right; margin-top: 10px; display: inline-flex">
            <input
                type="text"
                id="searchField"
                placeholder="Search Customer"
                onblur="searchCustomer()"
                style="width: unset; margin-right: 11px"
                class="form-control"
            />
            <select
                class="form-control"
                id="beatSearch"
                style="width: unset; margin-right: 11px"
                onchange="searchCustomer()"
            >
                <option value="">Filter By Beat</option>
                @foreach ($beats as $b)
                <option value="{{ $b->id }}">{{ $b->beat_name }}</option>
                @endforeach
            </select>
            <a
                href="javascript:void(0)"
                class="btn btn-success"
                onclick="searchCustomer(true)"
                >Clear Filter</a
            >
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Customer List</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-bordered mt-1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Beat Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="customersTable">
                                @include('pages.customers.single',['customers'=>$customers])
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
        
    </div>
    

    <div class="modal fade" id="customerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title"></h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <!-- General Form Elements -->
                    <!-- Vertical Form -->
                    <form
                        class="row g-3"
                        id="customer_form"
                        action="#"
                        method="post"
                    >
                        <div class="col-12">
                            <label for="beat_id" class="form-label"
                                >Select Beat</label
                            >
                            <select id="beat_id" class="form-select">
                                <option value="">Choose...</option>
                                @foreach ($beats as $b)
                                <option value="{{ $b->id }}">
                                    {{ $b->beat_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="customer_name" class="form-label"
                                >Customer Name</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="customer_name"
                                name="customer_name"
                                required
                            />
                        </div>

                        <div class="col-12">
                            <label for="customer_address" class="form-label"
                                >Customer Address</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="customer_address"
                                name="customer_address"
                                required
                            />
                        </div>
                        <div class="col-12">
                            <label for="customer_gst" class="form-label"
                                >Customer GST</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="customer_gst"
                                name="customer_gst"
                                required
                            />
                        </div>
                        <div class="col-12">
                            <label for="customer_gst" class="form-label"
                                >Customer Phone</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="customer_phone"
                                name="customer_phone"
                                required
                            />
                        </div>
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="customer_active"
                                    name="customer_active"
                                />
                                <label
                                    class="form-check-label"
                                    for="customer_active"
                                    >Is Active</label
                                >
                            </div>
                        </div>
                        <input
                            type="hidden"
                            id="store_url"
                            value="{{ route('customer.store') }}"
                        />
                        <input type="hidden" id="edit_url" value="" />
                    </form>
                    <!-- Vertical Form -->
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
                    <button
                        type="button"
                        onclick="submitCustomerForm()"
                        class="btn btn-primary"
                    >
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Basic Modal-->
    <input type="hidden" id="customers" value="{{ $customers }}" />
    @include('pages.customers.scripts')

</x-layout>
