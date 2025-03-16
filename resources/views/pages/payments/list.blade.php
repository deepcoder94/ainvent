<x-layout :currentPage="$currentPage">
    <style>
@-webkit-keyframes moving-gradient {
    0% { background-position: -250px 0; }
    100% { background-position: 250px 0; }
}

#invTable {
  width: 100%;
  tr {
    border-bottom: 1px solid rgba(0,0,0,.1);
    td {
      height: 50px;
      vertical-align: middle;
      padding: 8px;
      span {
        display: block;
      }
      &.td-1 {
        width: 20px;
        span {
          width: 20px;
          height: 20px;
        }
      }
      &.td-2 {
        width: 50px;
        span {
          background-color: rgba(0,0,0,.15);
          width: 50px;
          height: 50px;
        }
      }
      &.td-3 {
        width: 400px;
        // padding-right: 100px;
        span {
          height: 12px;
          background: linear-gradient(to right, #eee 20%, #ddd 50%, #eee 80%);
          background-size: 500px 100px;
          animation-name: moving-gradient;
          animation-duration: 1s;
          animation-iteration-count: infinite;
          animation-timing-function: linear;
          animation-fill-mode: forwards;
        }
      }
      &.td-4 {
      }
      &.td-5 {
        width: 100px;
        span {
          background-color: rgba(0,0,0,.15);
          width: 100%;
          height: 30px
        }
      }
    }
  }
}


    </style>
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
                                    <th>Invoice ID</th>
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
                                    <input type="text" id="invoice_no" class="form-control" onkeyup="searchByInvoice()">
                                </div>
        
                            </div>
                        </div>
            
                        
                        <table class="table table-bordered mt-3" id="invTable">
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
    @include('pages.payments.scripts')
</x-layout>
