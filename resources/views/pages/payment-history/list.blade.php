<x-layout :currentPage="$currentPage">
    <div>
        <h5 class="card-title">Payment History</h5>

        <div class="row">
            <div class="col-lg-4">
                <input
                type="text"
                placeholder="Invoice No."
                id="invoiceid"
                class="form-control mt-2 mb-2"
                onkeyup="searchPaymentHistory()"
            />
            
        </div>        
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
                                    <th>Invoice No.</th>
                                    <th>Customer Name</th>
                                    <th>View Payments</th>
                                    <th>Invoice Date</th>
                                </tr>
                            </thead>
                            <tbody id="history_tbody">
                                @include('pages.payment-history.single-payment',['filteredInvoices'=>$filteredInvoices])                                    
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.payment-history.single-invoice-detail-modal')

    

    <script>
        function viewSingleInvoicePayment(invid){

            let url = "{{ url('getSingleInvoicePaymentDetail') }}/"+invid;

            $.ajax({
            url: url,  // The URL defined in your routes
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
            },
            success: function(response) {  
                $("#historyBody").html(response)                   
                $("#modalDialogScrollable").modal('show');
                
            },
            error: function(xhr, status, error) {
            }
        });                   
            

        }

        function searchPaymentHistory(){
            let searchId = $("#invoiceid").val();
            if(searchId.length == 0){
                searchId = 'all';
            }

            let url ="{{ url('searchPayHistory') }}/"+searchId;
            $.ajax({
                url: url,  // The URL defined in your routes
                type: 'GET',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
                },
                data: { searchId:searchId },
                success: function(response) {    
                    $("#history_tbody").html(response) 
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    
                }
            });            
        }
    </script>
        
      </x-layout>
