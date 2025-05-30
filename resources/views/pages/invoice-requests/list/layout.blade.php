<x-layout :currentPage="$currentPage">
    <div class="row">
        <div class="col-lg-12 d-flex">
            <button class="btn btn-primary mt-2 mb-2" onclick="approveRequests()">
                Approve Requests
            </button>    
            <button class="btn btn-primary mt-2 mb-2" style="margin-left: 10px" onclick="previewRequests()">
                Preview Requests
            </button>                
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
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Beat</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>GST</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="invoice_body">
                                @include('pages.invoice-requests.list.single',['invoices'=>$invoices])
                            </tbody>
                        </table>

                    </div>
                </div>

                  
            </div>
        </div>
    </section>
    @include('pages.invoice-requests.list.script')
</x-layout>
