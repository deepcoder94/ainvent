@forelse ($filteredInvoices as $index => $i)
<tr>
    <td>{{ $i['invoice_number'] }}</td>
    <td>{{ $i['customer']['customer_name'] }}</td>
    <td><button type="button" class="btn btn-primary" onclick="viewSingleInvoicePayment({{$i['id']}})">View</button></td>
    <td>{{ \Carbon\Carbon::parse($i['created_at'])->timezone('Asia/Kolkata')->format('d-m-Y H:i:s') }}</td>
</tr>
    
@empty
<tr>
    <td colspan="4">No records found</td>
</tr>
@endforelse
