<x-layout :currentPage="$currentPage">
    
    <div id="customerPage" style="display:none">

    <div>
        <button class="btn btn-primary mt-2 mb-2" onclick="showCreateForm()">
            Add New
        </button>
        <button class="btn btn-dark mt-2 mb-2" onclick="startBulkUpload()">
            <i class="bi bi-upload me-1"></i> Upload Bulk
        </button>        
        <input type="file" id="csv-file" accept=".csv, .txt" style="display: none" onchange="uploadBulk()" />
        <button class="btn btn-warning mt-2 mb-2" onclick="exportCustomers()">
            <i class="bi bi-download me-1"></i> Export 
        </button>        

        <div style="float: right; margin-top: 10px; display: inline-flex">
            <input
                type="text"
                id="searchField"
                placeholder="Search Customer"
                onblur="searchCustomer()"
                style="width: unset; margin-right: 11px"
                class="form-control"
            />
            <select
                class="form-control"
                id="beatSearch"
                style="width: unset; margin-right: 11px"
                onchange="searchCustomer()"
            >
                <option value="">Filter By Beat</option>
                @foreach ($beats as $b)
                <option value="{{ $b->id }}">{{ $b->beat_name }}</option>
                @endforeach
            </select>
            <a
                href="javascript:void(0)"
                class="btn btn-success"
                onclick="searchCustomer(true)"
                >Clear Filter</a
            >
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Customer List</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-bordered mt-1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Beat Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="customersTable">
                                @include('pages.customers.single',['customers'=>$customers])
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    
        
    </div>
    
    @include('pages.customers.modal')
    <!-- End Basic Modal-->
    @include('pages.customers.scripts')

</x-layout>
