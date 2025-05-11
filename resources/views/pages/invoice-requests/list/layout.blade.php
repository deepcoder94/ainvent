<x-layout :currentPage="$currentPage">
    <div class="row">
        <div class="col-lg-3">
            <button class="btn btn-primary mt-2 mb-2" onclick="approveRequests()">
                Approve Requests
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
                                    <th>Request ID</th>
                                    <th>Customer Name</th>
                                    <th>Beat Name</th>
                                    <th>Date</th>
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
