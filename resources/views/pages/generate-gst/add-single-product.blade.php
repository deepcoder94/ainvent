<tr id="gst_row_{{ $id }}">
    <td>
        <input type="text" name="description[]" id="" class="form-control"/>
        <!-- Description -->
    </td>
    <td>
        <input type="text" name="code[]" id="" class="form-control" value="CODE"/>
        <!-- Code -->
    </td>
    <td>
        <input type="text" name="qty[]" id="" class="form-control" value="1"/>
        <!-- Qty -->
    </td>
    <td>
        <input type="text" name="unit[]" id="" class="form-control" value="NOS"/>
        <!-- Unit -->
    </td>
    <td>
        <input type="text" name="unit_price[]" id="" class="form-control" value="0.00"/>
        <!-- Unit Price -->
    </td>
    <td>
        <input type="text" name="discount[]" id="" class="form-control" value="0.00"/>
        <!-- Discount -->
    </td>
    <td>
        <input type="text" name="taxable_amt[]" id="" class="form-control" value="0.00"/>
        <!-- Taxable Amt -->
    </td>
    <td>
        <input type="text" name="tax_rate[]" id="" class="form-control" value="0.00"/>
        <!-- Tax Rate -->
    </td>
    <td>
        <input type="text" name="other_charges[]" id="" class="form-control" value="0.00"/>
        <!-- Other Charges -->
    </td>
    <td>
        <input type="text" name="total[]" id="" class="form-control" value="0.00"/>
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
