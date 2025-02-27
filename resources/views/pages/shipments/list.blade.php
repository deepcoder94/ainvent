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
                    <div class="card-body">
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
                                @forelse ($shipments as $invoice)
                                <tr
                                    class="inv_row_{{ $invoice['invoice']->id }} inv_rows" data-status="{{ $invoice['status'] }}"
                                >
                                    <td>
                                        <div class="form-check">
                                            <input
                                                class="form-check-input invoice-check"
                                                data-id="{{ $invoice['invoice']->id }}"
                                                type="checkbox"
                                                onchange="checkInvRow(event,{{ $invoice['invoice']->id }})"
                                            />
                                        </div>
                                    </td>
                                    <td>INV-{{ $invoice['invoice']->id }}</td>
                                    <td>
                                        {{ $invoice['invoice']->customer->customer_name }}
                                    </td>
                                    <td>
                                        {{ $invoice['invoice']->beat->beat_name }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($invoice['invoice']->created_at)->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        @if($invoice['status'] == 1)
                                        <span class="badge bg-success"
                                            >Shipped</span
                                        >
                                        @else
                                        <span class="badge bg-danger"
                                            >Not Shipped</span
                                        >
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        No records
                                    </td>
                                </tr>
                                @endforelse
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
