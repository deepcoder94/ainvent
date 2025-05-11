
<script>
    function showEditForm(id) {
        $("#mea_form")[0].reset();

        $.ajax({
            url: '{{ route("measurement.view", ":id") }}'.replace(':id', id),
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            success: function (response) {

                $("#modal-title").html("Edit Measurement");
                $("#mea_name").val(response.data.name);
                $("#mea_quantity").val(response.data.quantity);
                $("#edit_id").val(id);
                $("#meaModal").modal("show");
                
            }
        });

    }

    function showCreateForm() {
        $("#edit_url").val("");
        $("#mea_form")[0].reset();

        $("#modal-title").html("Create Measurement");
        $("#meaModal").modal("show");
    }

    function submitMeasurementForm() {
        let form = $("#mea_form").serializeArray();

        let isEdit = $("#edit_id").val();
        let url = '{{ route('measurement.create') }}';
        if (isEdit.length > 0) {
            let id = $("#edit_id").val();
            url = '{{ route("measurement.update", ":id") }}'.replace(':id', id);
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
    function showDeleteConfirmationDialog(id) {
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
                    url: '{{ route("measurement.delete", ":id") }}'.replace(':id', id),
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
        let devmode = '{{ checkDevMode() }}';            
        if(devmode == 0){
            showLoginPopup();
        }
        else{
            document.getElementById("distriSection").style.display = "block"; // Show actual content
            
        }

    };         
</script>