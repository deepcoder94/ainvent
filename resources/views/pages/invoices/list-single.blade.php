@forelse ($invoices as $invoice)
<tr class="inv_row_{{ $invoice->id }} inv_rows">
    <td>
        <div class="form-check">
            <input
                class="form-check-input invoice-check"
                data-id="{{ $invoice->id }}"
                type="checkbox"
                onchange="checkInvRow(event,'{{ $invoice->id }}')"
            />
        </div>
    </td>
    <td>{{ $invoice->invoice_number }}</td>
    <td>
        {{ $invoice->customer->customer_name }}
    </td>
    <td>{{ $invoice->beat->beat_name }}</td>
    <td>{{ $invoice->invoice_total }}</td>
    <td>
        {{ \Carbon\Carbon::parse($invoice->created_at)->timezone('Asia/Kolkata')->format('d-m-Y H:i:s') }}
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">
        No records
    </td>
</tr>
@endforelse