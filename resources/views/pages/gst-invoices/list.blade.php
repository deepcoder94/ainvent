<x-layout :currentPage="$currentPage">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">GST Invoice List</h5>

                        <!-- Table with stripped rows -->
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Invoice No.</th>
                                    <th>Customer Name</th>
                                    <th>Invoice Total</th>
                                    <th>Invoice Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.gst-invoices.single',['gst_invoices'=>$gst_invoices])

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>