<x-layout :currentPage="$currentPage">
    <div>
        <button class="btn btn-primary mt-2 mb-2" onclick="printInvoice()">Print Invoice</button>  
        <input type="text" name="" id="datepicker" placeholder="Search" style="float: right;margin-top:10px;width:unset" class="form-control">
        
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
                                            <input class="form-check-input" type="checkbox" id="gridCheck1" onchange="toggleMaster(event)">
                                          </div>                                           
                                    </th>
                                    <th>Invoice No.</th>
                                    <th>Customer Name</th>
                                    <th>Beat Name</th>
                                    <th>Invoice Date</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices as $invoice)
                                <tr class="inv_row_{{ $invoice->id }} inv_rows">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input invoice-check" data-id="{{ $invoice->id }}" type="checkbox" onchange="checkInvRow(event,'{{ $invoice->id }}')">
                                          </div>                      
                                    </td>
                                    <td>INV-{{ $invoice->id }}</td>
                                    <td>{{ $invoice->customer->customer_name }}</td>
                                    <td>{{ $invoice->beat->beat_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No records</td>
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
        function toggleMaster(event){
            if(event.target.checked){
                $(".invoice-check").prop("checked", true);
                let rows = document.querySelectorAll('.inv_rows');
                rows.forEach(function(row){
                    let rowtds = row.querySelectorAll('td')
                    let backgroundColor = event.target.checked ? "lightblue":"white"
                    rowtds.forEach(function(td) {
                        td.style.backgroundColor = backgroundColor;  // Set background color to light blue
                    });
                });
            }       
            if(!event.target.checked){
                $(".invoice-check").prop("checked", false);
                let rows = document.querySelectorAll('.inv_rows');
                rows.forEach(function(row){
                    let rowtds = row.querySelectorAll('td')
                    let backgroundColor = event.target.checked ? "lightblue":"white"
                    rowtds.forEach(function(td) {
                        td.style.backgroundColor = backgroundColor;  // Set background color to light blue
                    });
                });

            }     
        }

        function checkInvRow(event,id){
            let row = document.querySelector(`.inv_row_${id}`);
            let rowtds = row.querySelectorAll('td');
            let backgroundColor = event.target.checked ? "lightblue":"white"

            rowtds.forEach(function(td) {
                td.style.backgroundColor = backgroundColor;  // Set background color to light blue
            });            
        }

        function printInvoice(){
            let selectedInvoices = [];
            $(".invoice-check:checked").each(function(){                
                selectedInvoices.push($(this).data('id'));
            });
            if(selectedInvoices.length > 0){
                

                $.ajax({
                    url: "{{ route('loadPdf') }}",  // The URL defined in your routes
                    type: 'POST',
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
                    },
                    dataType: 'json',
                    data: { selectedInvoices:selectedInvoices },
                    success: function(response) {     
                        window.location.href = response.zipUrl;                
                    },
                    error: function(xhr, status, error) {
                        alert(error)
                    }
                });                

            }
            else{
                alert("Please select at least one invoice to print.");
                return;  // Exit the function if no invoices are selected.
            }            
        }

    </script>
</x-layout>