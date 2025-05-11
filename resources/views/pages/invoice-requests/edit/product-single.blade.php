<tr class="product_{{ $id }}">
    <td scope="col">
        <select class="form-control sel2input" name="product_id[]" id="product_slct_{{$id}}" onchange="getProductTypes(event,'{{ $id }}')">
            <option value="">Select</option>
            @foreach ($filteredProds as $p)
                <option value="{{ $p->id }}" style="display: {{ $p->inventory->total_stock > 0 ? 'block':'none' }}" {{ $p->id == $product->product_id ? 'selected':'' }}>{{ $p->product_name }} </option>
            @endforeach
        </select>
    </td>
    <td scope="col" >
        <select class="form-control sel2input" name="measurement_id[]" id="meas_{{ $id }}" onchange="getMaxQty('{{ $id }}')">
            <option value="">Select</option>
            @foreach ($measurements as $meas)
                <option value="{{ $meas->id }}" {{ $meas->id == $product->measurement_id ? 'selected':'' }}>{{ $meas->name }}</option>
                
            @endforeach

        </select>
    </td>
    <td scope="col">
        <input type="number" value="{{ $product->quantity }}" class="form-control" name="qty[]" id="qty_{{$id}}" onkeyup="restrictQty('{{$id}}')" data-maxqty="{{ $max_qty_data['max_qty'] }}" data-minrate="{{ $max_qty_data['min_rate'] }}">
        <span style="color:red;font-size:13px;font-weight:600" id="max_qty_span{{ $id }}">Max Quantity: {{ $max_qty_data['max_qty'] }}</span>
        <input type="hidden" name="maxqty[]" id="maxqty_{{$id}}" value="{{ $max_qty_data['max_qty'] }}">        
    </td>
    <td scope="col">
        <input type="text" value="{{ $product->rate }}" class="form-control" name="rate[]" id="rate_{{$id}}" onkeyup="restrictRate('{{$id}}')" data-minrate="{{ $max_qty_data['min_rate'] }}">
        <input type="hidden" name="minrate[]" id="minrate_{{$id}}" value="{{ $max_qty_data['min_rate'] }}">
        <span style="color:red;font-size:13px;font-weight:600" id="min_rate_span{{ $id }}">Min Rate: {{ $max_qty_data['min_rate'] }}</span>        
    </td>                    
    <td scope="col">
        <i class="bi bi-trash-fill text-danger" style="cursor:pointer" onclick="deleteProduct('{{ $id }}')"></i>
    </td>
  </tr>            
