<tr id="gst_row_{{ $id }}">
    <td>
        <select name="product_description[]" id="prod_{{$id}}" class="form-control" onchange="getHsnCode(event,'{{$id}}')">
            <option value="">Select Product</option>
            @forelse ($products as $p)
                <option value="{{ $p->product_name }}">{{ $p->product_name }}</option>                
            @empty
                
            @endforelse

        </select>
        {{-- <input type="text" name="description[]" id="" class="form-control"/> --}}
        <!-- Description -->
        <input type="text" name="product_code[]" id="code_{{$id}}" class="form-control mt-1" value="CODE"/>
        <!-- Code -->

    </td>
    <td>
        <input type="text" name="product_qty[]" id="qty_{{$id}}" class="form-control" value="1"  onkeyup="calculateTaxableAmt('{{$id}}')"/>
        <span style="color:red;font-size:13px;font-weight:600" id="max_qty_span{{ $id }}">Max Qty: </span>

        <!-- Qty -->
        <input type="hidden" name="product_unit[]" id="" class="form-control" value="NOS"/>
        <input type="text" name="product_unit_price[]" id="unit_price_{{$id}}" class="form-control mt-1" value="0.00" onkeyup="calculateTaxableAmt('{{$id}}')"/>
        <input type="hidden" name="product_min_rate[]" id="min_rate_{{$id}}" class="form-control mt-1" value="0.00"/>

        <!-- Unit Price -->
        <span style="color:red;font-size:13px;font-weight:600" id="min_rate_span{{ $id }}">Min Rate: </span>        
        
        <input type="hidden" name="product_discount[]" id="discount_{{$id}}" class="form-control" value="0.00"  onkeyup="calculateTaxableAmt('{{$id}}')"/>
        <!-- Discount -->

    </td>
    <td>
        <input type="text" name="product_taxable_amt[]" id="taxable_amt_{{$id}}" class="form-control" value="0.00"  onkeyup="calculateTaxableAmt('{{$id}}')"/>
        <!-- Taxable Amt -->
    </td>
    <td>
        <div class="row">
            <div class="col-lg-6">
                <input type="text" name="product_gst_rate[]" id="gst_rate{{$id}}" class="form-control" value="5.00"  onkeyup="calculateTaxableAmt('{{$id}}')"/>
                <input type="text" name="product_cess_rate[]" id="cess_rate{{$id}}" class="form-control mt-1" value="0.00"  onkeyup="calculateTaxableAmt('{{$id}}')"/>        
            </div>
            <div class="col-lg-6">
                <input type="text" name="product_state_cess_rate[]" id="state_cess_rate{{$id}}" class="form-control" value="0.00"  onkeyup="calculateTaxableAmt('{{$id}}')"/>
                <input type="text" name="product_non_advol_rate[]" id="non_advol_rate{{$id}}" class="form-control mt-1" value="0.00"  onkeyup="calculateTaxableAmt('{{$id}}')"/>                
            </div>
        </div>
        <!-- Tax Rate -->
    </td>
    <td>
        <input type="text" name="product_other_charges[]" id="other_charges_{{$id}}" class="form-control" value="0.00" onkeyup="calculateTaxableAmt('{{$id}}')"/>
        <!-- Other Charges -->
    </td>
    <td>
        <input type="text" name="product_total[]" id="total_{{$id}}" class="form-control" value="0.00"/>
        <!-- Total -->
    </td>
    <td>
        <span
            onclick="removeGstProduct('{{ $id }}')"
            ><i class="bi bi-trash" style="color: red; font-size: 23px;cursor: pointer;"></i
            ></span
        >
    </td>
</tr>
