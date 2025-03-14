<x-layout :currentPage="$currentPage">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Pay By Customer</h5>
                        <!-- Table with stripped rows -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <label for="beat_select">Select Beat</label>
                                    <select id="beat_select" class="form-control" onchange="getPaymentsByBeat()">
                                        <option value="">Choose</option>
                                        @foreach ($beats as $b)
                                            <option value="{{$b->id}}">{{ $b->beat_name }}</option>                                    
                                        @endforeach
                                    </select>
                                </div>        
                            </div>
                        </div>
            
                        
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Invoice Total</th>
                                    <th>Total Paid</th>
                                    <th>Total Due</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="paymentsTable">
                                @include('pages.payments.customer-single',['customerpayments'=>$customerpayments])
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>

                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Pay By Invoice</h5>
                        <!-- Table with stripped rows -->

                        <div class="row">
                            <div class="col-lg-12">
                                <div>
                                    <label for="beat_select">Search Invoice Number</label>
                                    <input type="text" id="invoice_no" class="form-control" onblur="searchByInvoice()">
                                </div>
        
                            </div>
                        </div>
            
                        
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Invoice ID</th>
                                    <th>Invoice Total</th>
                                    <th>Total Paid</th>
                                    <th>Total Due</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="invoicePaymentsTable">
                                @include('pages.payments.invoice-single',['customerpayments'=>$customerpayments])
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>                
            </div>
        </div>
    </section>
    <script>
            function showCreateForm(){
                $("#edit_url").val('');
                $("#customer_form")[0].reset();

                $("#modal-title").html('Create Customer');
                $("#customerModal").modal('show');
            }

            function confirmRecord(customer_id){
                let invtotal = $(`.btn_${customer_id}`).data("invoicetotal");
                let duetotal = $(`.btn_${customer_id}`).data("duetotal");

                
                let updateUrl = '{{ url('paymentsUpdate') }}/'+customer_id

                let paid_total = $(`#paid_total_${customer_id}`).val();
                paid_total = parseFloat(paid_total)
                
                let total = invtotal+duetotal;
                let newdue = total-paid_total
                                
                $.ajax({
                    url: updateUrl,  // The URL defined in your routes
                    type: 'POST',
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
                    },
                    dataType: 'json',
                    data: { due:newdue,isBeatCustomer:1 },
                    success: function(response) {
                        if(response.success){
                            alert(response.message)
                            location.reload();
                        }
                        else if(!response.success){
                            alert(response.message)
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(error.message)
                    }
                });
            }

            function getPaymentsByBeat(){
                let beatId = $("#beat_select").val();
                let url = "{{ url('getPaymentsByBeat') }}/"+beatId;
                $.ajax({
                    url: url,  // The URL defined in your routes
                    type: 'GET',
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
                    },
                    success: function(response) {
                        $("#paymentsTable").html(response)
                    },
                    error: function(xhr, status, error) {
                        alert(error.message)
                    }
                });
                
            }

            function searchByInvoice(){
                let invoiceNumber = $("#invoice_no").val();
                let url = "{{ url('getPaymentsByInvoiceId') }}/"+invoiceNumber;
                $.ajax({
                    url: url,  // The URL defined in your routes
                    type: 'GET',
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
                    },
                    success: function(response) {                        
                        $("#invoicePaymentsTable").html(response)
                    },
                    error: function(xhr, status, error) {
                        alert(error.message)
                    }
                });
                
            }

            function calcDue(){
                let invoice_total = parseFloat($("#inv_total").html());
                let dueTotal = parseFloat($("#dueTotal").html());
                let paid_total = parseFloat($("#paid_total").val());
                
                let due = invoice_total - paid_total;
                $("#dueTotal").html(due.toFixed(2))
            }

            function confirmInvRecord(){
                let dueTotal = parseFloat($("#dueTotal").html());
                let customerid = $(`#cnfBtn`).data("customerid");
                let updateUrl = '{{ url('paymentsUpdate') }}/'+customerid  
                $.ajax({
                    url: updateUrl,  // The URL defined in your routes
                    type: 'POST',
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
                    },
                    dataType: 'json',
                    data: { due:dueTotal,isBeatCustomer:0 },
                    success: function(response) {
                        if(response.success){
                            alert(response.message)
                            location.reload();
                            }
                        else if(!response.success){
                            alert(response.message)
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(error.message)
                    }
                });

            }


    </script>
</x-layout>
