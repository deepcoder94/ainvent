<script>
    function toggleMaster(event) {
        if (event.target.checked) {
            $(".invoice-check").prop("checked", true);
            let rows = document.querySelectorAll(".inv_rows");
            rows.forEach(function (row) {
                let rowtds = row.querySelectorAll("td");
                let backgroundColor = event.target.checked
                    ? "lightblue"
                    : "white";
                rowtds.forEach(function (td) {
                    td.style.backgroundColor = backgroundColor; // Set background color to light blue
                });
            });
        }
        if (!event.target.checked) {
            $(".invoice-check").prop("checked", false);
            let rows = document.querySelectorAll(".inv_rows");
            rows.forEach(function (row) {
                let rowtds = row.querySelectorAll("td");
                let backgroundColor = event.target.checked
                    ? "lightblue"
                    : "white";
                rowtds.forEach(function (td) {
                    td.style.backgroundColor = backgroundColor; // Set background color to light blue
                });
            });
        }
    }

    function checkInvRow(event, id) {
        let row = document.querySelector(`.inv_row_${id}`);
        let rowtds = row.querySelectorAll("td");
        let backgroundColor = event.target.checked ? "lightblue" : "white";

        rowtds.forEach(function (td) {
            td.style.backgroundColor = backgroundColor; // Set background color to light blue
        });
    }

    function approveRequests() {
        let selectedInvoices = [];
        $(".invoice-check:checked").each(function () {
            selectedInvoices.push($(this).data("id"));
        });
        if (selectedInvoices.length > 0) {
            $.ajax({
                url: "{{ route('invoice.request.approve') }}", // The URL defined in your routes
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ), // CSRF Token
                },
                dataType: "json",
                data: { selectedInvoices: selectedInvoices },
                success: function (response) {
                    alert('Requests Approved Successfully');
                    location.reload();
                },
                error: function (xhr, status, error) {
                    alert(error);
                },
            });
        } else {
            alert("Please select at least one invoice to print.");
            return; // Exit the function if no invoices are selected.
        }
    }

    function showDeleteConfirmation(id){
        let  url = '{{ route("invoice.request.delete", ":id") }}'.replace(':id', id);

        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to delete this Request?",
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
    
    function previewRequests(){
        let selectedInvoices = [];
        $(".invoice-check:checked").each(function () {
            selectedInvoices.push($(this).data("id"));
        });
        if (selectedInvoices.length > 0) {
            $.ajax({
                url: "{{ route('invoice.request.preview') }}", // The URL defined in your routes
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ), // CSRF Token
                },
                dataType: "json",
                data: { selectedInvoices: selectedInvoices },
                success: function (response) {
                    window.location.href = response.zipUrl;                    
                },
                error: function (xhr, status, error) {
                    alert(error);
                },
            });
        } else {
            alert("Please select at least one invoice to print.");
            return; // Exit the function if no invoices are selected.
        }

    }
</script>