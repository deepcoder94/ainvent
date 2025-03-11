<div class="row {{ $count>1?'mt-2':'' }}" id="productrecord_{{ $count }}">
    <div class="col-lg-4">
        <div class="col-12">
            <label
            for="inputNanme4"
            class="form-label"
            >Select Product</label>
            <select name="invoiceProduct[]" id="invproducts" class="form-control" onchange="getMaxQty(event,'{{$count}}')">
                <option value="">Select</option>
                @foreach ($products as $p)
                    <option value="{{ $p->id }}" data-maxqty='{{ $p->pivot->quantity }}'>{{ $p->product_name }}</option>
                @endforeach
            </select>                                                                                        
        </div>
    </div>
    <div class="col-lg-2">
        <div class="col-12">
            <label
            for="inputNanme4"
            class="form-label"
            >Qty</label>
            <input type="text" name="quantity[]" id="qty_{{$count}}" class="form-control" onkeyup="checkMaxQty('{{$count}}')">
        </div>
    </div>
    <div class="col-lg-2">
        <label for="" class="form-label" style="display: block">#</label>
        <button class="btn btn-primary" type="button" onclick="appendReturnProduct()">+</button>
        @if ($count>1)
        <button class="btn btn-danger" type="button" onclick="deleteReturnProduct('{{ $count }}')">-</button>
            
        @endif
    </div>

</div>
    