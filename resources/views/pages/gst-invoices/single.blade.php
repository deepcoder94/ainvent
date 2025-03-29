@forelse ($gst_invoices as $i)
    <tr>
        <td>{{ $i['invoice_number'] }}</td>
        <td>{{ $i['receipent_details']['recepent_name'] }}</td>
        <td>{{ $i['total_invoice_amount'] }}</td>
        <td>{{ \Carbon\Carbon::parse($i['invoice_date'])->timezone('Asia/Kolkata')->format('d-m-Y H:i:s') }}</td>
    </tr>    
@empty
    
@endforelse