<tr class="product_{{ $id }}">
    <td scope="col">
        <select class="form-control" name="product_id[]" id="product_slct_{{$id}}" onchange="getProductTypes(event,'{{ $id }}')">
            <option value="">Select</option>
            @foreach ($products as $p)
                <option value="{{ $p->id }}" style="display: {{ $p->inventory->total_stock > 0 ? 'block':'none' }}">{{ $p->product_name }} </option>
            @endforeach
        </select>
    </td>
    <td scope="col" >
        <select class="form-control" name="measurement_id[]" id="meas_{{ $id }}" onchange="getMaxQty('{{ $id }}')">
            <option value="">Select</option>

        </select>
    </td>
    <td scope="col">
        <input type="number" value="0" class="form-control" name="qty[]" id="qty_{{$id}}" onkeyup="restrictQty('{{$id}}')">
        <span style="color:red;font-size:13px;font-weight:600" id="max_qty_span{{ $id }}">Max Quantity: </span>
    </td>
    <td scope="col">
        <input type="text" value="0" class="form-control" name="rate[]">
    </td>                    
    <td scope="col">
        <i class="bi bi-trash-fill text-danger" style="cursor:pointer" onclick="deleteProduct('{{ $id }}')"></i>
    </td>
  </tr>            
