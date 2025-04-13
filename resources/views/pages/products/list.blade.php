<x-layout :currentPage="$currentPage">
    
    <div id="productsPage" style="display:none">
    <div class="mt-2 mb-2">
        <button
        class="btn btn-primary"
        onclick="showCreateForm()"
    >
        Add New
    </button>
    <button class="btn btn-dark mt-2 mb-2" onclick="startBulkUpload()">
        <i class="bi bi-upload me-1"></i> Upload Bulk
    </button>        
    <input type="file" id="csv-file" accept=".csv, .txt" style="display: none" onchange="uploadBulk()" />

    <button class="btn btn-warning mt-2 mb-2" onclick="exportProducts()">
        <i class="bi bi-download me-1"></i> Export 
    </button>        
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Products List</h5>
                        <!-- Table with stripped rows -->
                        <div class="table-responsive mt-1">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Rate</th>
                                        <th>GST Rate</th>
                                        <th>Types</th>
                                        <th>HSN Code</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('pages.products.single',['products'=>$products])
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
        
    </div>
    

    @include('pages.products.modal',['measurements'=>$measurements])    

    <script>
        function showCreateForm() {
            $("#edit_url").val("");
            $("#product_form")[0].reset();

            $("#modal-title").html("Create Product");
            $("#productModal").modal("show");
        }

        function showEditForm(product, edit_url) {
            $("#edit_url").val("");
            $("#product_form")[0].reset();
            let productJson = JSON.parse(product);

            $("#modal-title").html("Edit Product");
            $("#edit_url").val(edit_url);
            $("#product_name").val(productJson.product_name);
            $("#product_rate").val(productJson.product_rate);
            $("#product_hsn").val(productJson.product_hsn);
            $("#gst_rate").val(productJson.gst_rate);

            
            if (productJson.is_active == 1) {
                $("#product_active").prop("checked", true);
            } else {
                $("#product_active").prop("checked", false);
            }

            let measurements = productJson.measurements;
            // const measurementIds = measurements.map(measurement => measurement.id).join(',');
            measurements.some((m)=>{
                let mid = document.getElementById("product_measurements_"+m.id);
                if(mid){
                    mid.checked = true
                }
            });

            
            // $("#product_measurements").val(measurementIds.split(',')).trigger('change');            

            $("#productModal").modal("show");
        }

        function submitProductForm() {
            let form = $("#product_form").serializeArray();
            
            let isEdit = $("#edit_url").val();
            let url = $("#store_url").val();
            if (isEdit.length > 0) {
                url = $("#edit_url").val();
            }

            let groupedValues = {};

            // Group the values by name
            form.forEach(function (field) {
                if (field.name == "product_name" || field.name == "product_rate") {
                    return false;
                }

                if (!groupedValues[field.name]) {
                    groupedValues[field.name] = [];
                }
                groupedValues[field.name].push(field.value);
            });

            // Now create the array of objects with key-value pairs
            let finalData = [];
            let length = groupedValues["product_measurements[]"].length; // Assuming all fields have the same length

            // Create key-value pair objects for each product
            for (let i = 0; i < length; i++) {
                finalData.push(groupedValues["product_measurements[]"][i])
            }

            
            

            let data = {
                product_name: form.find((item) => item.name === "product_name")
                    .value,
                product_rate: form.find((item) => item.name === "product_rate")
                    .value,
                product_hsn: form.find((item) => item.name === "product_hsn")
                    .value,       
                gst_rate: form.find((item) => item.name === "gst_rate")
                    .value,                                 
                is_active: $("#product_active").prop("checked") ? 1 : 0,
                product_measurements: finalData
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
                text: "Do you want to delete this Products?",
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

        function startBulkUpload(){
            $("#csv-file").click();            
        }

        function uploadBulk(){
            var fileInput = $('#csv-file')[0];
            
            var file = fileInput.files[0];
            var formData = new FormData();

                formData.append('file_csv', file);

                // Send the file to the server using AJAX
                $.ajax({
                    url: "{{ route('product.upload') }}",
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
        
        function exportProducts(){
            $.ajax({
            url: "{{ route('generate.product.csv') }}", // The route to your export method
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
        
   // Function to show the login popup with username and password fields
        function showLoginPopup() {
            Swal.fire({
                title: 'Login to Continue',
                html: `
                    <input id="password" class="swal2-input" type="password" placeholder="Password">
                `,
                confirmButtonText: 'Login',
                preConfirm: () => {
                    const password = document.getElementById('password').value;
                    
                    // Simple validation: check if both fields are filled
                    if (!password) {
                        Swal.showValidationMessage('Both fields are required');
                        return false;
                    }
                    return { password };
                }
            }).then(result => {
                if (result.isConfirmed) {
                    const { password } = result.value;

                    // Optionally, send these credentials to the server via AJAX
                    validateLogin( password);
                }
            });
        }

        // Validate the login credentials (can be done via AJAX)
        function validateLogin(password) {
            // Simulate a login check (replace with your server-side validation)
            if ( password === "4561") {
                Swal.fire('Login Successful', 'You can now access the page.', 'success');
                document.getElementById("productsPage").style.display = "block"; // Show actual content
            } else {
                Swal.fire('Invalid Credentials', 'Please check your username and password.', 'error');
                showLoginPopup(); // Re-show the popup for retry
            }
        }

        // Show the login popup as soon as the page loads
        window.onload = function() {
            showLoginPopup();
        };         
    </script>
</x-layout>
