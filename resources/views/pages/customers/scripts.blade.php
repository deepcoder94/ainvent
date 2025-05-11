<script>
    function showCreateForm() {
        $("#edit_id").val("");
        $("#customer_form")[0].reset();

        $("#modal-title").html("Create Customer");
        $("#customerModal").modal("show");
    }

    function showEditForm(id) {
        $("#edit_id").val("");
        let url = '{{ route("customer.view", ":id") }}'.replace(':id', id);

        $.ajax({
            url: url, // The URL defined in your routes
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            success: function (response) {
                $("#customer_form")[0].reset();

                $("#modal-title").html("Edit Customer");
                $("#customer_name").val(response.data.customer_name);
                $("#customer_address").val(response.data.customer_address);
                $("#customer_gst").val(response.data.customer_gst);
                $("#customer_phone").val(response.data.customer_phone);

                if (response.data.is_active == 1) {
                    $("#customer_active").prop("checked", true);
                } else {
                    $("#customer_active").prop("checked", false);
                }
                $("#beat_id").val(response.data.beat_id);
                $("#edit_id").val(id);

                $("#customerModal").modal("show");
                
            }
        })
    }

    function submitCustomerForm() {
        let form = $("#customer_form").serializeArray();

        let isEdit = $("#edit_id").val();
        let url='';
        if (isEdit.length > 0) {
            url = '{{ route("customer.edit", ":id") }}'.replace(':id', isEdit);
        }
        else{
            url = '{{ route("customer.store") }}';        
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
    function showDeleteConfirmationDialog(id) {
        // Show SweetAlert confirmation dialog
        let  url = '{{ route("customer.delete", ":id") }}'.replace(':id', id);

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
                url: "{{ route('import.customer') }}",
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
        url: "{{ route('export.customer') }}", // The route to your export method
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
                validateLogin(password);
            }
        });
    }

    // Validate the login credentials (can be done via AJAX)
    function validateLogin(password) {
        // Simulate a login check (replace with your server-side validation)
        if (password === "4561") {
            Swal.fire('Login Successful', 'You can now access the page.', 'success');
            document.getElementById("customerPage").style.display = "block"; // Show actual content
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
            document.getElementById("customerPage").style.display = "block"; // Show actual content
        }
    };         
</script>