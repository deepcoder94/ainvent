<x-layout :currentPage="$currentPage">
    
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Inventory History</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-bordered mt-1">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Type</th>
                                    <th>Total Qty</th>
                                    <th>Buy Price</th>
                                    <th>Stock In / Out</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.inventory-history.single',['inventoryHistory'=>$inventoryHistory])
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>

        
      </x-layout>
