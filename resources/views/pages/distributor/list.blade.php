<x-layout :currentPage="$currentPage">
    <section class="section" id="distriSection" style="display:none">
        <div class="row">
            <div class="col-lg-6">
                @include('pages.distributor.details',['distributor'=>$distributor])
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Measurements</h5>
                        <button
                            class="btn btn-primary"
                            onclick="showCreateForm()"
                        >
                            Add New
                        </button>
                        <!-- Bordered Table -->
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.distributor.measurement_single',['measurements'=>$measurements])
                            </tbody>
                        </table>
                        <!-- End Bordered Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.distributor.modal') @if (session('success'))
    <script>
        Swal.fire({
            title: "Success!",
            text: "Distributor Details updated.",
            icon: "success",
            confirmButtonText: "OK",
        });
    </script>
    @endif

    <script>
        function showEditForm(measurement, edit_url) {
            $("#edit_url").val("");
            $("#mea_form")[0].reset();
            let measurementJson = JSON.parse(measurement);

            $("#modal-title").html("Edit Measurement");
            $("#edit_url").val(edit_url);
            $("#mea_name").val(measurementJson.name);
            $("#mea_quantity").val(measurementJson.quantity);
            $("#meaModal").modal("show");
        }

        function showCreateForm() {
            $("#edit_url").val("");
            $("#mea_form")[0].reset();

            $("#modal-title").html("Create Measurement");
            $("#meaModal").modal("show");
        }

        function submitMeasurementForm() {
            let form = $("#mea_form").serializeArray();

            let isEdit = $("#edit_url").val();
            let url = $("#store_url").val();
            if (isEdit.length > 0) {
                url = $("#edit_url").val();
            }

            let data = {
                name: form.find((item) => item.name === "mea_name").value,
                quantity: form.find((item) => item.name === "mea_quantity")
                    .value,
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
                text: "Do you want to delete this Measurement?",
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
                    validateLogin(password);
                }
            });
        }

        // Validate the login credentials (can be done via AJAX)
        function validateLogin( password) {
            // Simulate a login check (replace with your server-side validation)
            if (password === "4561") {
                Swal.fire('Login Successful', 'You can now access the page.', 'success');
                document.getElementById("distriSection").style.display = "block"; // Show actual content
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
