<x-layout :currentPage="$currentPage">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Edit Invoice Request {{ $invoice_request->id }}</h5>

                        @include('pages.invoice-requests.edit.form',[
                                'beats'=>$beats,
                                'customers'=>$customers,
                                'products'=>$products,
                                'measurements'=>$measurements,
                                'invoice_request'=>$invoice_request,
                                'product_html'=>$product_html,
                                'product_count'=>$product_count
                            ]
                            )
                        
                        <div>
                            <input type="hidden" id="product_count" value="{{ $product_count }}">
                            <button
                                class="btn btn-primary"
                                type="button"
                                onclick="submitInvoice('{{ $invoice_request->id }}')"
                            >
                                Save Invoice Request
                            </button>
                            <a
                            href="{{ route('invoice.request.list') }}"
                                class="btn btn-warning"
                            >
                                Back to List
                            </a>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.invoice-requests.edit.scripts')

</x-layout>
