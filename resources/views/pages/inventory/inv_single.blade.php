@forelse ($inventory as $i)
<tr>
    <td>{{ $i->item_code ?? '' }}</td>
    <td>{{ $i->product->product_name ?? 'N/A' }}</td>
    <td>{{ $i->buying_price ?? '' }}</td>
    <td>{{ $i->total_stock ?? '' }}</td>
</tr>
@empty
<tr>
    <td colspan="3" class="text-center">No records</td>
</tr>
@endforelse
