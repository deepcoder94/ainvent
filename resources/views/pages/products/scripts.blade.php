
<script>
    function showCreateForm() {
        $("#edit_url").val("");
        $("#product_form")[0].reset();

        $("#modal-title").html("Create Product");
        $("#productModal").modal("show");
    }

    function showEditForm(id) {
        $("#edit_id").val("");
        $("#product_form")[0].reset();
        let url = '{{ route("product.view", ":id") }}'.replace(':id', id);

        $.ajax({
            url: url, // The URL defined in your routes
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            success: function (response) {
                $("#modal-title").html("Edit Product");
                $("#edit_id").val(id);
                $("#product_name").val(response.data.product_name);
                $("#product_rate").val(response.data.product_rate);
                $("#product_hsn").val(response.data.product_hsn);
                $("#gst_rate").val(response.data.gst_rate);

                
                if (response.data.is_active == 1) {
                    $("#product_active").prop("checked", true);
                } else {
                    $("#product_active").prop("checked", false);
                }
                

                let measurements = response.data.measurements;
                measurements.some((m)=>{
                    let mid = document.getElementById("product_measurements_"+m.id);
                    if(mid){
                        mid.checked = true
                    }
                });


                $("#productModal").modal("show");

            }
        });

    }

    function submitProductForm() {
        let form = $("#product_form").serializeArray();
        
        let isEdit = $("#edit_id").val();
        let url = '';
        if (isEdit.length > 0) {
            url = '{{ route("product.edit", ":id") }}'.replace(':id', isEdit);
        }
        else{
            url = '{{ route("product.store") }}';        
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

    function showDeleteConfirmationDialog(id) {
        // Show SweetAlert confirmation dialog
        let  url = '{{ route("product.delete", ":id") }}'.replace(':id', id);

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
                url: "{{ route('import.product') }}",
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
        url: "{{ route('export.product') }}", // The route to your export method
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
        let devmode = '{{ checkDevMode() }}';            
        if(devmode == 0){
            showLoginPopup();
        }
        else{
            document.getElementById("productsPage").style.display = "block"; // Show actual content
        }

    };         
</script>