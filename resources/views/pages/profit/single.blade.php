@forelse ($groupedData as $profit)
    <tr>
        <td>{{ \Carbon\Carbon::parse($profit['created_at'])->timezone('Asia/Kolkata')->format('d-m-Y H:i:s') }}</td>
        <td>{{ $profit['invoice_number'] }}</td>
        <td>{{ $profit['total_profit'] }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="3">No records</td>
    </tr>
@endforelse
