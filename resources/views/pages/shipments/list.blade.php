<x-layout :currentPage="$currentPage">
    <div>
        <button class="btn btn-primary mt-2 mb-2" onclick="printShipment()">
            Print Shipment
        </button>
        <input
            type="text"
            name=""
            id="datepicker"
            placeholder="Search"
            style="float: right; margin-top: 10px; width: unset"
            class="form-control"
        />
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <!-- Table with stripped rows -->
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                id="gridCheck1"
                                                onchange="toggleMaster(event)"
                                            />
                                        </div>
                                    </th>
                                    <th>Invoice No.</th>
                                    <th>Customer Name</th>
                                    <th>Beat Name</th>
                                    <th>Invoice Date</th>
                                    <th>Ship Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.shipments.single',['shipments'=>$shipments])
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
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

        function printShipment() {
            let selectedInvoices = [];
            $(".invoice-check:checked").each(function () {
                selectedInvoices.push($(this).data("id"));
            });
            if (selectedInvoices.length > 0) {
                $.ajax({
                    url: "{{ route('createShipment') }}", // The URL defined in your routes
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
                        alert('Something went wrong');
                    },
                });
            } else {
                alert("Please select at least one invoice to print.");
                return; // Exit the function if no invoices are selected.
            }
        }
        
        document.addEventListener("DOMContentLoaded", function(ev){
            let rows = document.querySelectorAll(".inv_rows");
            rows.forEach(function (row) {
                if(row.dataset.status=='1'){
                    let rowtds = row.querySelectorAll("td");
                    let checkbox = row.querySelector('input')
                    checkbox.disabled = true
                    
                    let backgroundColor = "rgb(231, 252, 231)";                    
                    rowtds.forEach(function (td) {
                        td.style.backgroundColor = backgroundColor; // Set background color to light blue
                    });

                }
                
            })
        })
    </script>
</x-layout>
