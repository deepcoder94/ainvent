<x-layout :currentPage="$currentPage">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Products List</h5>
                        <button class="btn btn-primary" onclick="showCreateForm()">Add New</button>
                        <!-- Table with stripped rows -->
                        <table class="table datatable mt-1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Rate</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->product_rate }}</td>
                                    <td>
                                        <span class="badge  {{ $product->is_active == 1 ? 'bg-success':'bg-danger' }}">{{ $product->is_active == 1 ? 'Active':'Inactive' }}</span>
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-primary"
                                            onclick="showEditForm('{{ $product }}','{{ url('/updateProductById/')}}/{{ $product->id }}')"                                            
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-danger"
                                            onclick="showDeleteConfirmationDialog('{{ $product->id }}','{{ url('/deleteProductById/')}}/{{ $product->id }}')"                                            
                                        >
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal-title"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- General Form Elements -->
              <!-- Vertical Form -->
              <form class="row g-3" id="product_form" action="#" method="post">
                <div class="col-12">
                  <label for="product_name" class="form-label">Product Name</label>
                  <input type="text" class="form-control" id="product_name" name="product_name" required>
                </div>
                <div class="col-12">
                    <label for="product_rate" class="form-label">Product Rate</label>
                    <input type="text" class="form-control" id="product_rate" name="product_rate" required>
                  </div>                
                  <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="product_active" name="product_active">
                        <label class="form-check-label" for="product_active">Is Active</label>
                      </div>                  
    
                  </div>                      
                  <input type="hidden" id="store_url" value="{{ route('products.store') }}">
                  <input type="hidden" id="edit_url" value="">


              </form><!-- Vertical Form -->               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="submitProductForm()">Save changes</button>
            </div>
          </div>
        </div>
      </div><!-- End Basic Modal-->      
    <script>
            function showCreateForm(){
        $("#edit_url").val('');
        $("#product_form")[0].reset();

        $("#modal-title").html('Create Product');
        $("#productModal").modal('show');
    }

    function showEditForm(product,edit_url){
    $("#edit_url").val('');
    $("#product_form")[0].reset();
    let productJson = JSON.parse(product)

                    $("#modal-title").html('Edit Product');
                    $("#edit_url").val(edit_url);
                    $("#product_name").val(productJson.product_name);
                    $("#product_rate").val(productJson.product_rate);
                    if(productJson.is_active == 1){
                        $("#product_active").prop('checked', true);
                    }
                    else{
                        $("#product_active").prop('checked', false);

                    }
                    $("#productModal").modal('show');      

}

function submitProductForm(){
        let form = $("#product_form").serializeArray();

        let isEdit = $("#edit_url").val();
        let url = $("#store_url").val();
        if(isEdit.length > 0){
            url = $("#edit_url").val();
        }  
        
        let data = {
            product_name: form.find(item => item.name === 'product_name').value,
            product_rate: form.find(item => item.name === 'product_rate').value,
            is_active: $("#product_active").prop("checked")?1:0
        };
        

        $.ajax({
            url: url,  // The URL defined in your routes
            type: 'POST',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
            },
            dataType: 'json',
            data: data,
            success: function(response) {     
                if(response.success){
                    alert(response.message)
                    location.reload()
                }                       
                else if(!response.success){
                    alert(response.message)
                }
            },
            error: function(xhr, status, error) {
                alert(error)                
            }
    });
        
    }

    function showDeleteConfirmationDialog(id,url){
// Show SweetAlert confirmation dialog
Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this Products?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, proceed with AJAX request to delete the resource
                    $.ajax({
                        url: url,  // Your route to delete the resource
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',  // CSRF token for security
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', response.message, 'success');
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'There was an issue deleting the resource.', 'error');
                        }
                    });                                        
                } 
                else {
                    
                    // If the user canceled, do nothing
                }
            });        
    }

    </script>
</x-layout>