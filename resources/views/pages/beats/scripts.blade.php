<script>



    function showEditForm(id) {
        let url = '{{ route("beats.view", ":id") }}'.replace(':id', id);
        $.ajax({
            url: url, // The URL defined in your routes
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            success: function (response) {
                $("#edit_id").val("");
                $("#beat_form")[0].reset();

                $("#modal-title").html("Edit Beat");
                $("#edit_id").val(id);
                $("#beat_name").val(response.data.beat_name);
                $("#beat_address").val(response.data.beat_address);
                if (response.data.is_active == 1) {
                    $("#beat_active").prop("checked", true);
                } else {
                    $("#beat_active").prop("checked", false);
                }
                $("#beatModal").modal("show");
                
            }
        })
        // let beatJson = JSON.parse(beat);

    }

    function showCreateForm() {
        $("#edit_id").val("");
        $("#beat_form")[0].reset();

        $("#modal-title").html("Create Beat");
        $("#beatModal").modal("show");
    }

    function submitBeatForm() {
        let form = $("#beat_form").serializeArray();

        let isEdit = $("#edit_id").val();
        let url = '';
        if (isEdit.length > 0) {
            let id = $("#edit_id").val();
            url = '{{ route("beats.edit", ":id") }}'.replace(':id', id);
        }
        else{
            url = '{{ route("beats.store") }}';
        }
        
        let data = {
            beat_name: form.find((item) => item.name === "beat_name").value,
            beat_address: form.find((item) => item.name === "beat_address")
                .value,
            is_active: $("#beat_active").prop("checked") ? 1 : 0,
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
            text: "Do you want to delete this Beat? This will delete all customers associated with this Beat",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, proceed with AJAX request to delete the resource
                let url = '{{ route("beats.delete", ":id") }}'.replace(':id', id);

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
    function validateLogin(password) {
        // Simulate a login check (replace with your server-side validation)
        if (password === "4561") {
            Swal.fire('Login Successful', 'You can now access the page.', 'success');
            document.getElementById("beatPage").style.display = "block"; // Show actual content
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
            document.getElementById("beatPage").style.display = "block"; // Show actual content
        }
    };         
</script>