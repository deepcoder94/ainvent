@foreach ($history as $h)

<tr>
    <td>{{ $h->id }}</td>
    <td>{{ \Carbon\Carbon::parse($h->created_at)->timezone('Asia/Kolkata')->format('d-m-Y H:i:s') }}</td>
    <td>{{ $h->amount }}</td>
</tr>


@endforeach
