<script>
    var lastProductId = 0;
    var productNumber = 0;
    var isValid=false
    var isQtyValid=false
    var isRateValid = false;


    function clearInputErrors(field){
        $(`#${field}`).css('display','none');
    }

    function getCustomers() {
        clearInputErrors('invalid_beat');
        let beatId = parseInt($("#beat_id").val());
        let  url = '{{ route("beats.customers", ":id") }}'.replace(':id', beatId);

        $.ajax({
            url: url, // The URL defined in your routes
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            success: function (response) {
                let customers = response.customers

                let options = `<option value="">Choose</option>`;
                if (customers.length > 0) {
                    let optionsfiltered = customers
                        .map((item) => {
                            return `<option value="${item.id}">${item.customer_name}</option>`;
                        })
                        .join("");

                    options = options.concat(optionsfiltered);

                }                
                $("#customer_id").html(options);

            },
            error: function (xhr, status, error) {                
            },
        });        

    }

    function showAddProductModal() {
        lastProductId++;
        productNumber++;

        $("#no_item").hide();
        let  url = '{{ route("invoice.create.single_product", ":id") }}'.replace(':id', lastProductId);
        
        $.ajax({
            url: url, // The URL defined in your routes
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            success: function (response) {
                $("#products_tbody").append(response)
            },
            error: function (xhr, status, error) {                
                alert(xhr.responseJSON.message);
            },
        });
        
    }

    function getProductTypes(event,id){
        let selectedProduct = event.target.value;

        let  url = '{{ route("product.measurements", ":id") }}'.replace(':id', selectedProduct);

        $.ajax({
            url: url, // The URL defined in your routes
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            success: function (response) {
                let measu = response.data;
                let meas_html = $(`#meas_${id}`);
                if (measu.length > 0) {
                    let meahtml = '';
                    let selectProdcts = measu.map((mea) => {
                        meahtml += `<option value="${mea.id}">${mea.name}</option>`;
                    });
                    meas_html.html(meahtml);
                    meas_html.trigger('change');
                }
                
            },
            error: function (xhr, status, error) {                
                // alert(xhr.responseJSON.message);
            },
        });

        
        // let products = $("#products").val();
        // let productJson = JSON.parse(products);
        // let measurements = $("#measurements").val();
        // let measurementsJson = JSON.parse(measurements);
        
        
        // let pro = productJson.filter((p)=>{
        //     return p.id == selectedProduct
        // })
        // console.log(pro[0]);
        
        // let finalMeas = [];
        // if(pro[0].measurements.length > 0){
        //     let ids = pro[0].measurements.map((m)=>{
        //         return m.id
        //     });
            
            
        //     let ms = measurementsJson.filter((m)=>{
        //         return ids.includes(m.id)
        //     })
        //     finalMeas = ms
        // }      
        // else{
        //     finalMeas = measurementsJson
        // }    
        

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

        $("#invalid_beat").css("display","none");
        $("#invalid_customer").css("display","none");
        
        formValues.forEach((field)=>{
            if(field.name=='beat_id' && field.value.length==0){
                isValid=false
                $("#invalid_beat").css("display","block");
                $("#invalid_beat").html("Beat cannot be empty");
                return;
            }                
            if(field.name=='customer_id' && field.value.length==0){
                isValid=false
                $("#invalid_customer").css("display","block");
                $("#invalid_customer").html("Customer cannot be empty");
                return;
            }                       
        })
        

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

        if(!groupedValues["product_id[]"]){
            alert('Products cannot be empty')                
            isValid=false
            return;
        }
        
        let length = groupedValues["product_id[]"].length; // Assuming all fields have the same length

        // Create key-value pair objects for each product
        for (let i = 0; i < length; i++) {
            if(
                groupedValues["product_id[]"][i].length ==0 || 
                groupedValues["measurement_id[]"][i].length == 0 ||
                groupedValues["qty[]"][i].length == 0 ||
                groupedValues["rate[]"][i].length == 0 
            )
            {
                alert('Invalid inputs. please try again (Fields)')
                isValid=false
                return
            }
            finalData.push({
                product_id: groupedValues["product_id[]"][i],
                measurement_id: groupedValues["measurement_id[]"][i],
                qty: groupedValues["qty[]"][i],
                rate: groupedValues["rate[]"][i],
                minrate: groupedValues["minrate[]"][i],
            });
        }
        isValid=true
        if(!isQtyValid){
            alert('Invalid inputs. please check once (Quantity)')
            return;
        }

        let is_validation_active = $("#is_validation_active").prop("checked")
        if(!is_validation_active) {
            isRateValid = true
        }
        
        if(!isRateValid){
            alert('Invalid inputs. please check once (Rate)')
            return;
        }        
        
        let data = {
            beat_id: formValues.find((item) => item.name === "beat_id")
                .value,
            customer_id: formValues.find(
                (item) => item.name === "customer_id"
            ).value,
            products: finalData,
        };
                    
        let  url = '{{ route("invoice.create") }}';

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

    function getMaxQty(id){

        // selected product
        let selected_pro = $("#product_slct_"+id).val();
        
        //selected type
        let selected_type = $("#meas_"+id).val();

        let url = "{{ route('product.max_qty', ['id' => '__id__', 'typeId' => '__type__']) }}"
                .replace('__id__', selected_pro)
                .replace('__type__', selected_type);

        $.ajax({
            url: url, // The URL defined in your routes
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            success: function (response) {
                console.log(response);
                let minrate = response.min_rate
                let maxQty = response.max_qty
                $("#min_rate_span"+id).html('Min Rate: '+minrate);
                $("#max_qty_span"+id).html('Max Quantity: '+maxQty)
                $("#qty_"+id).attr({
                    'min':0,
                    'max':maxQty,
                    'step':0.1
                });
                $("#qty_"+id).attr('data-maxqty',maxQty);
                $("#qty_"+id).attr('data-minrate',minrate);
                $("#minrate_"+id).val(minrate)
                                
            },
            error: function (xhr, status, error) {                
                // alert(xhr.responseJSON.message);
            },
        });


    }

    function restrictQty(id){
        let qty = parseFloat($("#qty_"+id).val());
        let allowedqty = parseFloat($("#qty_"+id).attr('data-maxqty'));
                
        if(qty < allowedqty){            
            isQtyValid = true
        }   
        if(qty > allowedqty){
            isQtyValid = false
        }     
    }

    function restrictRate(id){

        let rate = parseFloat($("#rate_"+id).val());
        let allowedminrate = parseFloat($("#qty_"+id).attr('data-minrate'));
        if(rate > allowedminrate){
            isRateValid = true;
        }
        if(rate <= allowedminrate){
            isRateValid = false;
        }
    }
</script>