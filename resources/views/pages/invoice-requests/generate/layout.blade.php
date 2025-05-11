<x-layout :currentPage="$currentPage">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Generate Request</h5>

                        @include('pages.invoice-requests.generate.form',[
                                'beats'=>$beats,
                                'customers'=>$customers,
                                'products'=>$products,
                                'measurements'=>$measurements
                            ]
                            )
                        
                        <div>
                            <button
                                class="btn btn-primary"
                                type="button"
                                onclick="submitInvoice()"
                            >
                                Submit Request
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.invoice-requests.generate.scripts')

</x-layout>
