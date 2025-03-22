<script>
    var index = 0;
    var gstProducts = [];
    function showProductDetail() {
        $("#gstProductsForm")[0].reset();
        index = 0;
        $("#gstproduct-tbody").html("");
        $(".sel2input").select2()    

        $("#ExtralargeModal").modal("show");
    }

    function addGstProduct() {
        index++;
        let url = "{{ url('addGstProduct') }}/" + index;
        $.ajax({
            url: url, // The URL defined in your routes
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            success: function (response) {
                $("#gstproduct-tbody").append(response);
            },
            error: function (xhr, status, error) {},
        });
    }

    function submitGstProductForm() {
        let formValues = $("#gstProductsForm").serializeArray();
        let groupedValues = {};

        // Group the values by name
        formValues.forEach(function (field) {
            if (!groupedValues[field.name]) {
                groupedValues[field.name] = [];
            }
            groupedValues[field.name].push(field.value);
        });

        let finalData = [];

        let length = groupedValues["code[]"].length; // Assuming all fields have the same length

        // Create key-value pair objects for each product
        for (let i = 0; i < length; i++) {
            finalData.push({
                description: groupedValues["description[]"][i],
                code: groupedValues["code[]"][i],
                qty: groupedValues["qty[]"][i],
                unit: groupedValues["unit[]"][i],
                unit_price: groupedValues["unit_price[]"][i],
                discount: groupedValues["discount[]"][i],
                taxable_amt: groupedValues["taxable_amt[]"][i],
                gst_rate: groupedValues["gst_rate[]"][i],
                cess_rate: groupedValues["cess_rate[]"][i],
                state_cess_rate: groupedValues["state_cess_rate[]"][i],
                non_advol_rate: groupedValues["non_advol_rate[]"][i],

                other_charges: groupedValues["other_charges[]"][i],
                total: groupedValues["total[]"][i],
            });
        }

        finalData.map((d) => {
            gstProducts.push(d);
        });

        let total_taxable_amt = 0;
        let total_tax = 0;
        let tax_rate = 0;
        let total_gst = 0;
        let grandtotal = 0;
        let other_charge = 0;        
        
        gstProducts.map((p)=>{
            
            total_taxable_amt += parseFloat(p.taxable_amt)            
            total_gst += (parseFloat(p.gst_rate) / 100) * parseFloat(p.taxable_amt)
            grandtotal += parseFloat(p.total)
            other_charge += parseFloat(p.other_charges)

            // let taxable_amt = p.qty * p.unit_price;

            // let total_gst_ = (tax_rate / 100) * taxable_amt
            // grand_total += (taxable_amt+total_gst)              
            // total_taxable_amt += taxable_amt
        });
        $("#gst_taxable_amt").val(total_taxable_amt);
        $("#gst_cgst").val((total_gst/2).toFixed(2));
        $("#gst_sgst").val((total_gst/2).toFixed(2));
        $("#gst_total_inv").val(grandtotal);
        $("#gst_other_charges").val(other_charge);

        
        $("#gst_calc_tbody").css('display','contents');


        let html = "";
        gstProducts.map((p, i) => {
            html += `
            <tr id="gst_list_product_${i}">
                <td>
                    <input type="text" class="form-control" name="product_description[]" value="${p.description}" />
                </td>
                <td>
                    <input type="text" class="form-control" name="product_code[]" value="${p.code}"></td>
                <td>
                    <input type="text" class="form-control" name="product_qty[]" value="${p.qty}" />
                </td>
                <td>
                    <input type="text" class="form-control" name="product_unit[]" value="${p.unit}" />
                </td>
                <td>
                    <input type="text" class="form-control" name="product_unit_price[]" value="${p.unit_price}" />
                </td>
                <td>
                    <input type="text" class="form-control" name="product_discount[]" value="${p.discount}" />                    
                </td>
                <td>
                    <input type="text" class="form-control" name="product_taxable_amt[]" value="${p.taxable_amt}" />                    
                </td>
                <td>
                    <div class="row">
                        <div class="col-lg-6">
                    <input type="text" class="form-control" name="gst_rate[]" value="${p.gst_rate}" />                    
                    <input type="text" class="form-control" name="cess_rate[]" value="${p.cess_rate}" />                                                                
                        </div>
                        <div class="col-lg-6">
                    <input type="text" class="form-control" name="state_cess_rate[]" value="${p.state_cess_rate}" />                    
                    <input type="text" class="form-control" name="non_advol_rate[]" value="${p.non_advol_rate}" />                                                                
                        
                        </div>
                    </div>

                </td>
                <td>
                    <input type="text" class="form-control" name="product_other_charges[]" value="${p.other_charges}" />                    
                </td>
                <td>
                    <input type="text" class="form-control" name="product_total[]" value="${p.total}" />                    
                </td>
                <td>
                    <span onclick="removeGstProductList('${i}')">
                        <i class="bi bi-trash" style="color: red; font-size: 23px;cursor:pointer"></i>
                    </span>
                </td>
            </tr>
            `;
        });
        $("#allProductstd").html(html);
        $("#ExtralargeModal").modal('hide');
    }

    function removeGstProduct(i) {
        $("#gst_row_" + i).remove();
        i--;
    }

    function removeGstProductList(i) {
        
        $("#gst_list_product_" + i).remove();
        gstProducts.splice(i)
        if(gstProducts.length == 0){
            $("#gst_calc_tbody").css('display','none');
        }
        
    }

    function generateGstInvoice(){
        let formValues = $("#gst_invoice_form").serializeArray();
        let url = "{{ url('generateGstInvoice') }}";
        $.ajax({
            url: url, // The URL defined in your routes
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            data:formValues,
            dataType: "json",
            success: function (response) {
                window.location.href = response.zipUrl;
            },
            error: function (xhr, status, error) {},
        });

    }

    function getHsnCode(event,id){
        let product_name = event.target.value        
        let url = "{{ url('getHsnCodeByProduct') }}/" + product_name;
        $.ajax({
            url: url, // The URL defined in your routes
            type: "GET",
            dataType:'json',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            success: function (response) {
                $("#code_"+id).val(response.data.product_hsn)
                
            },
            error: function (xhr, status, error) {},
        });        
    }

    function calculateTaxableAmt(id){
        let qty = $(`#qty_${id}`).val();
        let unit_price = $(`#unit_price_${id}`).val();
        let discount = $(`#discount_${id}`).val();
        let taxable_amt = $(`#taxable_amt_${id}`).val();
        let other_charges = $(`#other_charges_${id}`).val();
        let gst_rate = $(`#gst_rate${id}`).val();
        let cess_rate = $(`#cess_rate${id}`).val();
        let state_cess_rate = $(`#state_cess_rate${id}`).val();
        let non_advol_rate = $(`#non_advol_rate${id}`).val();

        qty = qty.length > 0 ? parseFloat(qty):0.00;
        unit_price = unit_price.length > 0 ?parseFloat(unit_price):0.00
        discount = discount.length > 0 ? parseFloat(discount)  : 0.00
        taxable_amt = taxable_amt.length > 0? parseFloat(taxable_amt) :0.00;
        other_charges = other_charges.length > 0? parseFloat(other_charges) :0.00;        
        gst_rate = gst_rate.length > 0? parseFloat(gst_rate) :0.00;        
        cess_rate = cess_rate.length > 0? parseFloat(cess_rate) :0.00;        
        state_cess_rate = state_cess_rate.length > 0? parseFloat(state_cess_rate) :0.00;        
        non_advol_rate = non_advol_rate.length > 0? parseFloat(non_advol_rate) :0.00;        

        let gtotal = 0;
        
        taxable_amt = (qty * unit_price) - discount
        

        // Tax calc
        let tx = (gst_rate / 100) * taxable_amt
        gtotal = tx + taxable_amt + other_charges

        $(`#taxable_amt_${id}`).val(taxable_amt.toFixed(3))
        $(`#total_${id}`).val(gtotal.toFixed(3))

    }
</script>