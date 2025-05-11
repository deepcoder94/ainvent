@forelse ($shipments as $invoice)
<tr
    class="inv_row_{{ $invoice['invoice']->id }} inv_rows" data-status="{{ $invoice['status'] }}"
>
    <td>
        <div class="form-check">
            <input
                class="form-check-input invoice-check"
                data-id="{{ $invoice['invoice']->id }}"
                type="checkbox"
                onchange="checkInvRow(event,{{ $invoice['invoice']->id }})"
            />
        </div>
    </td>
    <td>{{ $invoice['invoice']->invoice_number ?? '-' }}</td>
    <td>
        {{ $invoice['invoice']->customer->customer_name ?? '-' }}
    </td>
    <td>
        {{ $invoice['invoice']->beat->beat_name ?? '-' }}
    </td>
    <td>
        {{ \Carbon\Carbon::parse($invoice['invoice']->created_at)->timezone('Asia/Kolkata')->format('d-m-Y H:i:s') }}
    </td>
    <td>
        @if($invoice['status'] == 1)
        <span class="badge bg-success"
            >Shipped</span
        >
        @else
        <span class="badge bg-danger"
            >Not Shipped</span
        >
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">
        No records
    </td>
</tr>
@endforelse