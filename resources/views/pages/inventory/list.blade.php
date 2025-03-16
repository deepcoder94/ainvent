<x-layout :currentPage="$currentPage">
    <div class="mt-2 mb-2">
        <button class="btn btn-primary" onclick="showCreateForm()">Add New</button>  
        <button class="btn btn-dark mt-2 mb-2" onclick="startBulkUpload()">
            <i class="bi bi-upload me-1"></i> Upload Bulk
        </button>        
        <input type="file" id="csv-file" accept=".csv, .txt" style="display: none" onchange="uploadBulk()" />
    
        <button class="btn btn-warning mt-2 mb-2" onclick="exportInventory()">
            <i class="bi bi-download me-1"></i> Export 
        </button>        
    
    </div>    
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Inventory</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-bordered mt-1">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Product Name</th>
                                    <th>Buying Price</th>
                                    <th>Total Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.inventory.inv_single',['inventory'=>$inventory])
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.inventory.inv_modal')
    @include('pages.inventory.scripts')
      </x-layout>
