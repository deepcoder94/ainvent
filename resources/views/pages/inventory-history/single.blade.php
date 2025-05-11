
@forelse ( $inventoryHistory as $i )
<tr>
    <td>{{ $i->product->product_name ?? '-' }}</td>
    <td>{{ $i->measurement->name ?? '-' }}</td>
    <td>{{ $i->stock_out_in ?? '-' }}</td>
    <td>{{ $i->buying_price ?? '-' }}</td>
    <td>
        @if($i->stock_action == 'add')
            <span class="badge bg-success">Added</span>                                        
        @elseif($i->stock_action == 'return')
            <span class="badge bg-success">Returned</span>                                                    
        @else
            <span class="badge bg-danger">Deducted</span>   
        @endif                                        

    </td>
    <td>{{ \Carbon\Carbon::parse($i->created_at)->timezone('Asia/Kolkata')->format('d-m-Y H:i:s') }}</td>
</tr>
    
@empty
<tr>
    <td colspan="5">No records found!</td>
</tr>    
@endforelse