<tr id="gst_row_{{ $id }}">
    <td>
        <select name="description[]" id="prod_{{$id}}" class="form-control sel2input" onchange="getHsnCode(event,'{{$id}}')">
            <option value="">Select Product</option>
            @forelse ($products as $p)
                <option value="{{ $p->product_name }}">{{ $p->product_name }}</option>                
            @empty
                
            @endforelse

        </select>
        {{-- <input type="text" name="description[]" id="" class="form-control"/> --}}
        <!-- Description -->
    </td>
    <td>
        <input type="text" name="code[]" id="code_{{$id}}" class="form-control" value="CODE"/>
        <!-- Code -->
    </td>
    <td>
        <input type="text" name="qty[]" id="qty_{{$id}}" class="form-control" value="1"  onkeyup="calculateTaxableAmt('{{$id}}')"/>
        <!-- Qty -->
    </td>
    <td>
        <input type="text" name="unit[]" id="" class="form-control" value="NOS"/>
        <!-- Unit -->
    </td>
    <td>
        <input type="text" name="unit_price[]" id="unit_price_{{$id}}" class="form-control" value="0.00" onkeyup="calculateTaxableAmt('{{$id}}')"/>
        <!-- Unit Price -->
    </td>
    <td>
        <input type="text" name="discount[]" id="discount_{{$id}}" class="form-control" value="0.00"  onkeyup="calculateTaxableAmt('{{$id}}')"/>
        <!-- Discount -->
    </td>
    <td>
        <input type="text" name="taxable_amt[]" id="taxable_amt_{{$id}}" class="form-control" value="0.00"  onkeyup="calculateTaxableAmt('{{$id}}')"/>
        <!-- Taxable Amt -->
    </td>
    <td>
        <div class="row">
            <div class="col-lg-6">
                <input type="text" name="gst_rate[]" id="gst_rate{{$id}}" class="form-control" value="5.00"  onkeyup="calculateTaxableAmt('{{$id}}')"/>
                <input type="text" name="cess_rate[]" id="cess_rate{{$id}}" class="form-control" value="0.00"  onkeyup="calculateTaxableAmt('{{$id}}')"/>        
            </div>
            <div class="col-lg-6">
                <input type="text" name="state_cess_rate[]" id="state_cess_rate{{$id}}" class="form-control" value="0.00"  onkeyup="calculateTaxableAmt('{{$id}}')"/>
                <input type="text" name="non_advol_rate[]" id="non_advol_rate{{$id}}" class="form-control" value="0.00"  onkeyup="calculateTaxableAmt('{{$id}}')"/>                
            </div>
        </div>
        <!-- Tax Rate -->
    </td>
    <td>
        <input type="text" name="other_charges[]" id="other_charges_{{$id}}" class="form-control" value="0.00" onkeyup="calculateTaxableAmt('{{$id}}')"/>
        <!-- Other Charges -->
    </td>
    <td>
        <input type="text" name="total[]" id="total_{{$id}}" class="form-control" value="0.00"/>
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
