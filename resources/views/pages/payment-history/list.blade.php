<x-layout :currentPage="$currentPage">
    
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Payment History</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-bordered mt-1">
                            <thead>
                                <tr>
                                    <th>Invoice No.</th>
                                    <th>Customer Name</th>
                                    <th>View Payments</th>
                                    <th>Invoice Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($filteredInvoices as $index => $i)
                                <tr>
                                    <td>{{ $i['invoice_number'] }}</td>
                                    <td>{{ $i['customer']['customer_name'] }}</td>
                                    <td><button type="button" class="btn btn-primary" onclick="viewSingleInvoicePayment({{$i['id']}})">View</button></td>
                                    <td>{{ \Carbon\Carbon::parse($i['created_at'])->timezone('Asia/Kolkata')->format('d-m-Y H:i:s') }}</td>
                                </tr>
                                    
                                @empty
                                <tr>
                                    <td colspan="4">No records found</td>
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
    </script>
        
      </x-layout>
