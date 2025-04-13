<x-layout :currentPage="$currentPage">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Generate Invoice</h5>

                        @include('pages.generate-invoice-new.invoice_form',[
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
                                Submit Invoice
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.generate-invoice-new.scripts')

</x-layout>
