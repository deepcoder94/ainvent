<x-layout :currentPage="$currentPage">
    <div class="row">
        <div class="col-lg-2">
            <button class="btn btn-primary mt-2 mb-2" onclick="printInvoice()">
                Print Invoice
            </button>    
        </div>
        <div class="col-lg-2">
            <input
            type="text"
            id="invoiceId"
            placeholder="Invoice ID"
            class="form-control mt-2 mb-2"
            onblur="searchInvoice()"
            onkeyup="searchInvoice()"
        />

        </div>
        <div class="col-lg-2">
            <input
            type="text"
            id="datepicker"
            placeholder="Search Date"
            class="form-control mt-2 mb-2"
            onchange="searchInvoice()"
        />

        </div>
        <div class="col-lg-2 mt-3">
            <select id="beatSelection" class="form-control mt-2 mb-2 sel2input" onchange="searchInvoice()">
                <option value="">Beats</option>
                @forelse ($beats as $c)
                    <option value="{{ $c->id }}">{{ $c->beat_name }}</option>
                @empty
                    
                @endforelse
            </select>
        </div>        
        <div class="col-lg-2 mt-3">
            <select id="customerSelection" class="form-control mt-2 mb-2 sel2input" onchange="searchInvoice()">
                <option value="">Customer</option>
                @forelse ($customers as $c)
                    <option value="{{ $c->id }}">{{ $c->customer_name }}</option>
                @empty
                    
                @endforelse
            </select>
        </div>

        <div class="col-lg-1">
            <button
            class="btn btn-success mt-2 mb-2"
            onclick="searchInvoice(true)"
        >
            Clear
        </button>
        </div>

    </div>
    <div class="row mb-2 mt-2">
        <div class="col-lg-2">
            Current Page
            <select class="form-control" id="pageDate" onchange="searchInvoice()">
                @forelse ($pages as $p)
                    <option value="{{ $p['date'] }}">{{ $p['date'] }}</option>
                @empty
                    
                @endforelse
            </select>
        </div>
    </div>
    <div>

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
                                    <th>Invoice Total</th>
                                    <th>Invoice Date</th>
                                </tr>
                            </thead>
                            <tbody id="invoice_body">
                                @include('pages.invoices.list-single',['invoices'=>$invoices])
                            </tbody>
                        </table>

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
</x-layout>
