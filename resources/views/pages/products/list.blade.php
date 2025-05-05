<x-layout :currentPage="$currentPage">
    
    <div id="productsPage" style="display:none">
    <div class="mt-2 mb-2">
        <button
        class="btn btn-primary"
        onclick="showCreateForm()"
    >
        Add New
    </button>
    <button class="btn btn-dark mt-2 mb-2" onclick="startBulkUpload()">
        <i class="bi bi-upload me-1"></i> Upload Bulk
    </button>        
    <input type="file" id="csv-file" accept=".csv, .txt" style="display: none" onchange="uploadBulk()" />

    <button class="btn btn-warning mt-2 mb-2" onclick="exportProducts()">
        <i class="bi bi-download me-1"></i> Export 
    </button>        
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Products List</h5>
                        <!-- Table with stripped rows -->
                        <div class="table-responsive mt-1">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Rate</th>
                                        <th>GST Rate</th>
                                        <th>Types</th>
                                        <th>HSN Code</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('pages.products.single',['products'=>$products])
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
        
    </div>
    

    @include('pages.products.modal',['measurements'=>$measurements])    

    @include('pages.products.scripts')

</x-layout>
