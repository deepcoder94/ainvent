<x-layout :currentPage="$currentPage">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
    
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Generate Invoice</h5>
            <form id="invoice_form" method="post" action="#">
                  <div class="row">
                    <div class="col-lg-6">
                        <div class="col-12">
                            <label for="inputNanme4" class="form-label">Select Beat</label>
                            <select id="beat_id" name="beat_id" class="form-select" onchange="getCustomers(event)">
                                <option value="">Choose...</option>
                                @foreach ($beats as $b)
                                    <option value="{{ $b->id }}">{{ $b->beat_name }}</option>
                                @endforeach
                              </select>                            
                          </div>          
                    </div>                    
                    <div class="col-lg-6">
                        <div class="col-12">
                            <label for="inputNanme4" class="form-label">Select Customer</label>
                            <select id="customer_id" class="form-select" name="customer_id">
                                <option value="">Choose...</option>
                            </select>                            
                            <input type="hidden" id="customers" value="{{ $customers }}">
                            <input type="hidden" id="products" value="{{ $products }}">
                            <input type="hidden" id="measurements" value="{{ $measurements }}">
                            <input type="hidden" id="store_url" value="{{ route('newInvoiceCreate') }}">
                          </div>
          
                    </div>  
                    <div class="col-lg-12 mt-4">
                        <div class="d-flex justify-content-between">
                            <div>
                                <label for="inputNanme4" class="form-label">Select Products</label>
                            </div>
                            <div>
                                <button class="btn btn-primary" type="button" onclick="showAddProductModal()">Add Products</button>
                            </div>
                        </div>
              <!-- Bordered Table -->
              <table class="table table-bordered mt-2">
                <thead>
                  <tr>
                    <th scope="col">Product name</th>
                    <th scope="col">Measurement</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Rate</th>
                    <th scope="col">#</th>
                  </tr>
                </thead>
                <tbody id="products_tbody">
                  <tr id="no_item">
                    <td colspan="7" class="text-center">
                        No products added
                    </td>
                  </tr>
                </tbody>
              </table>
              <!-- End Bordered Table -->
                    
                    </div>                                      
                  </div>
                </form>
                <div>
                    <button class="btn btn-primary" type="button" onclick="submitInvoice()">Submit Invoice</button>
                </div>
                </div>
              </div>
            </div>
        </div>
    </section>

    <script>
        var lastProductId = 0;
        var productNumber = 0;


        function getCustomers(){
            let beatId = parseInt($("#beat_id").val());
 
            let customers  = $("#customers").val();
            let customerJson = JSON.parse(customers)
            const filteredData = customerJson.filter(item => item.beat_id === beatId);

            let options = `<option value="">Choose</option>`;
            if(filteredData.length > 0) {
                let optionsfiltered = filteredData.map((item)=>{
                    return `<option value="${item.id}">${ item.customer_name }</option>`;
                }).join('');
                
               options = options.concat(optionsfiltered)
            }
            $("#customer_id").html(options)            
        }

        function showAddProductModal(){
            lastProductId++
            productNumber++
            
            
            $("#no_item").hide();

            let products = $("#products").val();
            let productJson = JSON.parse(products)
            let slcthtml = `<select class="form-control" name="product_id[]">`;
                slcthtml += `<option value="">Select</option>`

            if(productJson.length > 0){
                let selectProdcts = productJson.map((product)=>{
                    slcthtml += `<option value="${ product.id }">${ product.product_name }</option>`
                });            

            }
            slcthtml += `</select>`;

            let measurements = $("#measurements").val();
            let measurementsJson = JSON.parse(measurements)
            let meahtml = `<select class="form-control" name="measurement_id[]">`;
                meahtml += `<option value="">Select</option>`

            if(measurementsJson.length > 0){
                let selectProdcts = measurementsJson.map((mea)=>{
                    meahtml += `<option value="${ mea.id }">${ mea.name }</option>`
                });            

            }
            meahtml += `</select>`;            

            let productsTr = `
                  <tr class="product_${lastProductId}">
                    <td scope="col">
                        ${slcthtml}
                    </td>
                    <td scope="col" >
                        ${meahtml}
                    </td>
                    <td scope="col">
                        <input type="text" value="0" class="form-control" name="qty[]">
                    </td>
                    <td scope="col">
                        <input type="text" value="0" class="form-control" name="rate[]">
                    </td>                    
                    <td scope="col">
                        <i class="bi bi-trash-fill text-danger" onclick="deleteProduct(${lastProductId})" style="cursor:pointer"></i>
                    </td>
                  </tr>            
            `;
            $("#products_tbody").append(productsTr)
            
        }

        function deleteProduct(id){
            productNumber--
            
            $(`.product_${id}`).remove();            
            if(productNumber == 0){
                $("#no_item").show();
            }            
            else{
                $("#no_item").hide();
            }
        }

        function submitInvoice(){
            
            let formValues = $("#invoice_form").serializeArray();
            let groupedValues = {};

            // Group the values by name
            formValues.forEach(function(field) {
                if(field.name == 'beat_id' || field.name == 'customer_id'){
                    return false
                }
                
                if (!groupedValues[field.name]) {
                    groupedValues[field.name] = [];
                }
                groupedValues[field.name].push(field.value);
            });

            // Now create the array of objects with key-value pairs
            let finalData = [];
            let length = groupedValues["product_id[]"].length; // Assuming all fields have the same length

            // Create key-value pair objects for each product
            for (let i = 0; i < length; i++) {
                finalData.push({
                    product_id: groupedValues["product_id[]"][i],
                    measurement_id: groupedValues["measurement_id[]"][i],
                    qty: groupedValues["qty[]"][i],
                    rate: groupedValues["rate[]"][i],

                });
            }


            let data = {
                beat_id: formValues.find(item => item.name === 'beat_id').value,
                customer_id: formValues.find(item => item.name === 'customer_id').value,
                products: finalData
            };
            
            let url = $("#store_url").val();
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
                    alert(error)                
                }
            });            
        }
    </script>
</x-layout>