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

                    <input type="hidden" id="edit_id" value="" />
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
