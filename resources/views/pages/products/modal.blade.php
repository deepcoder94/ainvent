    <!-- Modal for Create/Edit -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
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
                    <form
                        class="row g-3"
                        id="product_form"
                        action="#"
                        method="post"
                    >
                        <div class="col-12">
                            <label for="product_name" class="form-label"
                                >Product Name</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="product_name"
                                name="product_name"
                                required
                            />
                        </div>
                        <div class="col-12">
                            <label for="product_rate" class="form-label"
                                >Product Rate</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="product_rate"
                                name="product_rate"
                                required
                            />
                        </div>
                        <div class="col-12">
                            <label for="product_hsn" class="form-label"
                                >Product GSN</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="product_hsn"
                                name="product_hsn"
                                required
                            />
                        </div>                        
                        <div class="col-12">
                            <label for="product_rate" class="form-label"
                                >Measurement Types</label
                            >
                            <div class="row">
                                @foreach ($measurements as $m)
                                <div class="col-lg-3">
                                    <div class="form-check">
                                        <input class="form-check-input measurements" name="product_measurements[]" id="product_measurements_{{ $m->id }}" type="checkbox" value="{{ $m->id }}">
                                        <label class="form-check-label">
                                            {{ $m->name }}
                                        </label>
                                      </div>
        
                                </div>
                                @endforeach
    
                            </div>

                                {{-- <select class="form-select" name="product_measurements[]" id="product_measurements" multiple aria-label="multiple select example">
                                  @foreach ($measurements as $m)
                                      <option value="{{ $m->id }}">{{ $m->name }}</option>                                      
                                  @endforeach
                                </select> --}}
            
                        </div>                        
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="product_active"
                                    name="product_active"
                                />
                                <label
                                    class="form-check-label"
                                    for="product_active"
                                    >Is Active</label
                                >
                            </div>
                        </div>
                        <input
                            type="hidden"
                            id="store_url"
                            value="{{ route('products.store') }}"
                        />
                        <input type="hidden" id="edit_url" value="" />
                    </form>
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
                        class="btn btn-primary"
                        onclick="submitProductForm()"
                    >
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->
