<x-layout :currentPage="$currentPage">
    
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Inventory</h5>
                        <button class="btn btn-primary" onclick="showCreateForm()">Add New</button>
                        <!-- Table with stripped rows -->
                        <table class="table table-bordered mt-1">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Product Name</th>
                                    <th>Total Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inventory as $i)
                                <tr>
                                    <td>{{ $i->item_code }}</td>
                                    <td>{{ $i->product->product_name }}</td>
                                    <td>{{ $i->total_stock }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">No records</td>
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
    <div class="modal fade" id="inventoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal-title"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- General Form Elements -->
              <!-- Vertical Form -->
              <form class="row g-3" id="inventory_form" action="#" method="post">
                <table class="table table-bordered" id="invProds">
                    <tr id="inv_rec_1">
                        <td>
                            <select name="inv_product[]" class="form-control">
                                <option value="">Select Product..</option>
                                @foreach ($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->product_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                        <select name="inv_mea[]" class="form-control">
                                <option value="">Select Type..</option>
                                @foreach ($measurements as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>                            
                        </td>
                        <td>
                            <input type="text" name="inv_qty[]" class="form-control" placeholder="Quantity">
                        </td>
                        <td>
                            <i class="bi bi-plus-square-fill text-success" style="font-size: 24px;cursor:pointer" onclick="addInvProduct()"></i>
                        </td>
                        <td>
                        </td>
                    </tr>
                </table>

              </form><!-- Vertical Form -->               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="submitInvForm()">Save changes</button>
            </div>
          </div>
        </div>
      </div><!-- End Basic Modal-->        

      <script>

        var invProductCount = 1;
        function showCreateForm(){
            $("#edit_url").val('');
            $("#inventory_form")[0].reset();

            $("#modal-title").html('Add Inventory');
            $("#inventoryModal").modal('show');
        }        

    function addInvProduct(){
        invProductCount++;
        let invHtml = `
                    <tr id="inv_rec_${invProductCount}">
                        <td>
                            <select name="inv_product[]" class="form-control">
                                <option value="">Select Product..</option>
                                @foreach ($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->product_name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                        <select name="inv_mea[]" class="form-control">
                                <option value="">Select Type..</option>
                                @foreach ($measurements as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                        </select>                            
                        </td>
                        <td>
                            <input type="text" name="inv_qty[]" class="form-control" placeholder="Quantity">
                        </td>

                        <td>
                            <i class="bi bi-plus-square-fill text-success" style="font-size: 24px;cursor:pointer" onclick="addInvProduct()"></i>
                        </td>
                        <td>
                        <i class="bi bi-trash-fill text-danger" style="font-size: 24px;cursor:pointer" onclick="removeInvProduct('${invProductCount}')"></i>                            
                        </td>

                    </tr>        
        `;
        
        $("#invProds").append(invHtml);

    }

    function submitInvForm(){
        let formValues = $("#inventory_form").serializeArray();
            let groupedValues = {};
            let isValidForm = true
            // Group the values by name
            formValues.forEach(function(field) {
                if (!groupedValues[field.name]) {
                    groupedValues[field.name] = [];
                }
                if(field.value.length ==0){
                    isValidForm = false;
                }
                
                groupedValues[field.name].push(field.value);
            });

            // Now create the array of objects with key-value pairs
            let finalData = [];
            let length = groupedValues["inv_product[]"].length; // Assuming all fields have the same length

            // Create key-value pair objects for each product
            for (let i = 0; i < length; i++) {
                finalData.push({
                    inv_product: groupedValues["inv_product[]"][i],
                    inv_mea: groupedValues["inv_mea[]"][i],
                    inv_qty: groupedValues["inv_qty[]"][i]
                });
            }    
            
            if(!isValidForm){
                alert('Invalid form. Please fill all inputs')
            }
            else{
                $.ajax({
                url: "{{ route('inventory.store') }}",  // The URL defined in your routes
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
                },
                dataType: 'json',
                data: {
                    records: finalData
                },
                success: function(response) {     
                    if(response.success){
                        Swal.fire({
                            title: 'Success!',
                            text: 'Invoice Saved Successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((res)=>{
                            if(res.isConfirmed){
                                location.reload();
                            }                            
                        });                                    
                    }
                    else if(!response.success){
                        alert(response.message)
                    }                                                            
                },
                error: function(xhr, status, error) {
                }
            });                   
            }
    }

    function removeInvProduct(id){
        $(`#inv_rec_${id}`).remove();
        invProductCount--

    }
      </script>      
      </x-layout>
