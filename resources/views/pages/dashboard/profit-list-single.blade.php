@forelse ($profits as $profit)
    <tr>
        <td>{{ \Carbon\Carbon::parse($profit->created_at)->format('F j, Y') }}</td>
        <td>{{ $profit->invoice_number }}</td>
        <td>{{ $profit->profit_amount }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="3">No records</td>
    </tr>
@endforelse
