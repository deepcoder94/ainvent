@forelse ($payments as $date => $beats)
@forelse ($beats as $beatId => $data)
    <tr>
        <td>{{ \Carbon\Carbon::parse($date)->timezone('Asia/Kolkata')->format('d-m-Y H:i:s') }}</td>
        <td>{{ $data['beat_name'] }}</td>
        <td>{{ $data['total_amount'] }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="3">No records</td>
    </tr>
@endforelse
@empty
<tr>
    <td colspan="3">No records</td>
</tr>
@endforelse
