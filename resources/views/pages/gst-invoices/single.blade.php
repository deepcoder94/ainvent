@forelse ($gst_invoices as $i)
    <tr>
        <td>{{ $i['invoice_number'] }}</td>
        <td>{{ $i['receipent_details']['recepent_name'] }}</td>
        <td>{{ $i['total_invoice_amount'] }}</td>
        <td>{{ $i['invoice_date'] }}</td>
    </tr>    
@empty
    
@endforelse