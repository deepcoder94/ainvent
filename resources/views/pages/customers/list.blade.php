<x-layout :currentPage="$currentPage">
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
                                    <th>Due</th>
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
    <script>
        function showCreateForm() {
            $("#edit_url").val("");
            $("#customer_form")[0].reset();

            $("#modal-title").html("Create Customer");
            $("#customerModal").modal("show");
        }

        function showEditForm(customer, edit_url) {
            $("#edit_url").val("");
            $("#customer_form")[0].reset();
            let customerJson = JSON.parse(customer);

            $("#modal-title").html("Edit Customer");
            $("#edit_url").val(edit_url);
            $("#customer_name").val(customerJson.customer_name);
            $("#customer_address").val(customerJson.customer_address);
            $("#customer_gst").val(customerJson.customer_gst);
            $("#customer_phone").val(customerJson.customer_phone);

            if (customerJson.is_active == 1) {
                $("#customer_active").prop("checked", true);
            } else {
                $("#customer_active").prop("checked", false);
            }
            $("#beat_id").val(customerJson.beat_id);
            $("#customerModal").modal("show");
        }

        function submitCustomerForm() {
            let form = $("#customer_form").serializeArray();

            let isEdit = $("#edit_url").val();
            let url = $("#store_url").val();
            if (isEdit.length > 0) {
                url = $("#edit_url").val();
            }

            let data = {
                customer_name: form.find(
                    (item) => item.name === "customer_name"
                ).value,
                customer_address: form.find(
                    (item) => item.name === "customer_address"
                ).value,
                customer_gst: form.find((item) => item.name === "customer_gst")
                    .value,
                customer_phone: form.find(
                    (item) => item.name === "customer_phone"
                ).value,
                is_active: $("#customer_active").prop("checked") ? 1 : 0,
                beat_id: $("#beat_id").val(),
            };

            $.ajax({
                url: url, // The URL defined in your routes
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ), // CSRF Token
                },
                dataType: "json",
                data: data,
                success: function (response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else if (!response.success) {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert(error);
                },
            });
        }
        function showDeleteConfirmationDialog(id, url) {
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to delete this Customer?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, proceed with AJAX request to delete the resource
                    $.ajax({
                        url: url, // Your route to delete the resource
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}", // CSRF token for security
                        },
                        success: function (response) {
                            Swal.fire("Deleted!", response.message, "success");
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            Swal.fire(
                                "Error!",
                                "There was an issue deleting the resource.",
                                "error"
                            );
                        },
                    });
                } else {
                    // If the user canceled, do nothing
                }
            });
        }

        function searchCustomer(clearSearch) {
            if (clearSearch) {
                $("#searchField").val("");
                $("#beatSearch").val("");
            }

            $.ajax({
                url: "{{ route('customer.search') }}", // The URL defined in your routes
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ), // CSRF Token
                },
                data: {
                    searchField: $("#searchField").val(),
                    beatSearch: $("#beatSearch").val(),
                },
                success: function (response) {
                    $("#customersTable").html(response);
                },
                error: function (xhr, status, error) {
                    console.log(error);
                },
            });
        }

        function startBulkUpload(){
            $("#csv-file").click();            
        }

        function uploadBulk(){
            var fileInput = $('#csv-file')[0];
            console.log(fileInput);
            
            var file = fileInput.files[0];
            var formData = new FormData();

                formData.append('file_csv', file);

                // Send the file to the server using AJAX
                $.ajax({
                    url: "{{ route('customer.upload') }}",
                    method: 'POST',
                    data: formData,
                    headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ), // CSRF Token
                    },
                    processData: false, // Don't process the data
                    contentType: false, // Don't set content-type header
                    success: function(response) {
                        if (response.success) {
                            Swal.fire("Uploaded!", 'Successfully Uploaded!', "success");
                            location.reload();                            
                        } else if (response.error) {
                            alert(response.error)
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(error)
                    }
                });
        }

        function exportCustomers(){
            $.ajax({
            url: "{{ route('generate.customer.csv') }}", // The route to your export method
            type: 'GET',
            headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ), // CSRF Token
                    },
            success: function(response) {
                window.location.href = response.url_path;
            },
            error: function(xhr, status, error) {
                alert('There was an error exporting the CSV. Please try again.');
            }
        });                
        }
    </script>
</x-layout>
