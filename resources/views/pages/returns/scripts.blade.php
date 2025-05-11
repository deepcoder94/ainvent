
<script>
    var recordIndex = 0;
    var isFormValid=true
    function getProducts(ev){
        recordIndex=1;
        let invoiceId = $("#invoiceId").val();
        let url = "{{ route('return.view', ['id' => '__id__', 'index' => '__index__']) }}"
                .replace('__id__', invoiceId)
                .replace('__index__', recordIndex);


        let  viewUrl = '{{ route("invoice.view", ":id") }}'.replace(':id', invoiceId);

        let options = [];
        $.ajax({
                url: url,  // The URL defined in your routes
                type: 'GET',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
                },
                success: function(response) {
                    $("#products").html(response)

                    $.ajax({
                        url: viewUrl,  // The URL defined in your routes
                        type: 'GET',
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
                        },
                        success: function(res){
                            $("#invoice_view").html(res)                            
                        },
                        error: function(xhr, status, error){

                        }
                    });

                },
                error: function(xhr, status, error) {
                    alert(error.message)
                }
            });
                   
    }

    function appendReturnProduct(){
        recordIndex++;
        let invoiceId = $("#invoiceId").val();

        let url = "{{ route('invoice.products', ['id' => '__id__', 'index' => '__index__']) }}"
                .replace('__id__', invoiceId)
                .replace('__index__', recordIndex);

        let options = [];
        $.ajax({
                url: url,  // The URL defined in your routes
                type: 'GET',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
                },
                success: function(response) {
                    $("#products").append(response)
                },
                error: function(xhr, status, error) {
                    alert(error.message)
                }
            });

    }
    function deleteReturnProduct(id){
        $("#productrecord_"+id).remove()
    }

    function submitReturn(){
        let formValues = $("#returnForm").serializeArray();            
        let groupedValues = {};

        // Group the values by name
        formValues.forEach(function (field) {
            if (field.name == "invoice_id") {
                return false;
            }

            if (!groupedValues[field.name]) {
                groupedValues[field.name] = [];
            }
            groupedValues[field.name].push(field.value);
        });

        // Now create the array of objects with key-value pairs
        let finalData = [];
        let length = groupedValues["invoiceProduct[]"].length; // Assuming all fields have the same length

        // Create key-value pair objects for each product
        for (let i = 0; i < length; i++) {
            finalData.push({
                invoiceProduct: groupedValues["invoiceProduct[]"][i],
                quantity: groupedValues["quantity[]"][i],
            });
        }
        let data = {
            invoice_id: formValues.find((item) => item.name === "invoice_id")
                .value,
            products: finalData,
        };
        if(!isFormValid){
            alert('Invalid inputs. please check once');
            return;
        }
        let url = '{{ route("return.store") }}';        
        $.ajax({
                url: url,  // The URL defined in your routes
                type: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
                },
                data:data,
                success: function(response) {
                    if(response.success){
                        alert(response.message)
                        location.reload();
                    }
                    else{
                        alert(response.message)
                    }
                },
                error: function(xhr, status, error) {
                    alert(error.message)
                }
            });
        
        
    }

    function getMaxQty(ev,index){
        let sel = document.getElementById('invproducts');     
        let selected = sel.options[sel.selectedIndex];
        var extra = selected.getAttribute('data-maxqty');

        $("#qty_"+index).attr("data-maxqty",extra);
        $("#max_qty_"+index).html('Max Qty: '+extra);
        
    }

    function checkMaxQty(index){

        let inp_qty = parseFloat($("#qty_"+index).val());
        let max_qty = parseFloat($("#qty_"+index).attr("data-maxqty"));
        if(inp_qty<=max_qty){
            isFormValid=true
        }
        if(inp_qty>max_qty){
            isFormValid=false
        }
        
    }

</script>
