<x-layout :currentPage="$currentPage">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Generate Invoice</h5>

                        @include('pages.invoices.invoice_form',['beats'=>$beats,'customers'=>$customers,'products'=>$products,'measurements'=>$measurements])
                        
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

    <script>
        var lastProductId = 0;
        var productNumber = 0;

        function getCustomers() {
            let beatId = parseInt($("#beat_id").val());

            let customers = $("#customers").val();
            let customerJson = JSON.parse(customers);
            const filteredData = customerJson.filter(
                (item) => item.beat_id === beatId
            );

            let options = `<option value="">Choose</option>`;
            if (filteredData.length > 0) {
                let optionsfiltered = filteredData
                    .map((item) => {
                        return `<option value="${item.id}">${item.customer_name}</option>`;
                    })
                    .join("");

                options = options.concat(optionsfiltered);
            }
            $("#customer_id").html(options);
        }

        function showAddProductModal() {
            lastProductId++;
            productNumber++;

            $("#no_item").hide();

            let products = $("#products").val();
            let productJson = JSON.parse(products);
            
            let slcthtml = `<select class="form-control" name="product_id[]" onchange="getProductTypes(event,${lastProductId})">`;
            slcthtml += `<option value="">Select</option>`;

            if (productJson.length > 0) {
                let selectProdcts = productJson.map((product) => {
                    slcthtml += `<option value="${product.id}">${product.product_name}</option>`;
                });
            }
            slcthtml += `</select>`;

            let measurements = $("#measurements").val();
            let measurementsJson = JSON.parse(measurements);
            let meahtml = `<select class="form-control" name="measurement_id[]" id="meas_${lastProductId}">`;
            meahtml += `<option value="">Select</option>`;
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
            $("#products_tbody").append(productsTr);
        }

        function getProductTypes(event,id){
            let products = $("#products").val();
            let productJson = JSON.parse(products);
            let selectedProduct = event.target.value;
            let measurements = $("#measurements").val();
            let measurementsJson = JSON.parse(measurements);

            let pro = productJson.filter((p)=>{
                return p.id == selectedProduct
            })
            
            let finalMeas = [];
            if(pro[0].measurements.length > 0){
                let ids = pro[0].measurements.map((m)=>{
                    return m.measurement_id
                });
                
                let ms = measurementsJson.filter((m)=>{
                    return ids.includes(m.id)
                })
                finalMeas = ms
            }      
            else{
                finalMeas = measurementsJson
            }    
            
            let meas_html = $(`#meas_${id}`);
            if (finalMeas.length > 0) {
                let meahtml = '';
                let selectProdcts = finalMeas.map((mea) => {
                    meahtml += `<option value="${mea.id}">${mea.name}</option>`;
                });
                meas_html.html(meahtml);
            }

        }

        function deleteProduct(id) {
            productNumber--;

            $(`.product_${id}`).remove();
            if (productNumber == 0) {
                $("#no_item").show();
            } else {
                $("#no_item").hide();
            }
        }

        function submitInvoice() {
            let formValues = $("#invoice_form").serializeArray();
            let groupedValues = {};

            // Group the values by name
            formValues.forEach(function (field) {
                if (field.name == "beat_id" || field.name == "customer_id") {
                    return false;
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
                beat_id: formValues.find((item) => item.name === "beat_id")
                    .value,
                customer_id: formValues.find(
                    (item) => item.name === "customer_id"
                ).value,
                products: finalData,
            };

            let url = $("#store_url").val();
            $.ajax({
                url: url, // The URL defined in your routes
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ), // CSRF Token
                },
                dataType: "json",
                data: data,
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Success!",
                            text: "Invoice Saved Successfully.",
                            icon: "success",
                            confirmButtonText: "OK",
                        }).then((res) => {
                            if (res.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else if (!response.success) {
                        alert(response.message);
                    }
                },
                error: function (xhr, status, error) {
                    alert(error);
                },
            });
        }
    </script>
</x-layout>
