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
    <td>{{ $invoice->id }}</td>
    <td>
        {{ $invoice->customer->customer_name }}
    </td>
    <td>{{ $invoice->beat->beat_name }}</td>
    <td>
        {{ \Carbon\Carbon::parse($invoice->created_at)->timezone('Asia/Kolkata')->format('d-m-Y H:i:s') }}
    </td>
    <td>
        <a class="btn btn-primary" href="{{ route('invoice.request.edit', ['id' => $invoice->id]) }}">Edit</a>
        <button class="btn btn-danger" onclick="showDeleteConfirmation('{{ $invoice->id }}')">Delete</button>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">
        No records
    </td>
</tr>
@endforelse