<script>
    var index = 0;
    var gstProducts = [];
    function showProductDetail() {
        $("#gstProductsForm")[0].reset();
        index = 0;
        $("#gstproduct-tbody").html("");
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
                tax_rate: groupedValues["tax_rate[]"][i],
                other_charges: groupedValues["other_charges[]"][i],
                total: groupedValues["total[]"][i],
            });
        }

        finalData.map((d) => {
            gstProducts.push(d);
        });

        let total_taxable_amt = 0;
        let tax_rate = 0;
        let total_gst = 0;
        let grand_total=0;
        
        gstProducts.map((p)=>{
            let taxable_amt = p.qty * p.unit_price;

            let total_gst_ = (tax_rate / 100) * taxable_amt
            grand_total += (taxable_amt+total_gst)              
            total_taxable_amt += taxable_amt
        });
        $("#gst_taxable_amt").val(total_taxable_amt);
        $("#gst_cgst").val((total_taxable_amt/2).toFixed(2));
        $("#gst_sgst").val((total_taxable_amt/2).toFixed(2));
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
                    <input type="text" class="form-control" name="product_tax_rate[]" value="${p.tax_rate}" />                    
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
</script>