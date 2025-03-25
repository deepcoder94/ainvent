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

    function printInvoice() {
        let selectedInvoices = [];
        $(".invoice-check:checked").each(function () {
            selectedInvoices.push($(this).data("id"));
        });
        if (selectedInvoices.length > 0) {
            $.ajax({
                url: "{{ route('loadPdf') }}", // The URL defined in your routes
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

    function searchInvoice(clearFilter=false){
        if(clearFilter){
        $("#invoiceId").val('');
        $("#datepicker").val('');
        $("#customerSelection").val('');
        $("#beatSelection").val('');
        $("#pageDate").val('');

    }            
        let invId = $("#invoiceId").val();
        let invDate = $("#datepicker").val();
        let invCustomer = $("#customerSelection").val();  
        let invBeat = $("#beatSelection").val();    
        let invDate2 = $("#pageDate").val();            


        $.ajax({
        url: "{{ route('invoice.search') }}",  // The URL defined in your routes
        type: 'GET',
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
        },
        data: { invId:invId,invDate: invDate,invCustomer:invCustomer,invBeat:invBeat,invDate2:invDate2 },
        success: function(response) {     
            $("#invoice_body").html(response)
        },
        error: function(xhr, status, error) {
            console.log(error);
            
        }
});            
    }

function searchCustomerInvoice(){

}        
    
</script>