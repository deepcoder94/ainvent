<x-layout :currentPage="$currentPage">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <form action="#" method="POST" id="returnForm">

                    <div class="card-body tablecontainer">
                        <div>
                            <h5 class="card-title">Generate Return <span style="float: right;color:white" class="btn btn-primary" onclick="submitReturn()">Submit</span></h5>    
                        </div>

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="col-12">
                                    <label
                                    for="inputNanme4"
                                    class="form-label"
                                    >Select Invoice</label>
                                    <select id="invoiceId" name="invoice_id" class="form-control" onchange="getProducts(event)">
                                        <option value="">Select</option>
                                        @foreach ($invoices as $i)
                                            <option value="{{ $i->id }}">{{ $i->invoice_number }}</option>                                            
                                        @endforeach
                                    </select>
                                                                                        
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div id="products"></div>
                            </div>
                        </div>
                    </div>
                </form>

                </div>
            </div>
        </div>
        
    </section>
    @include('pages.returns.scripts')
</x-layout>