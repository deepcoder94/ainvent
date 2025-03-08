@forelse ($beats as $beat)
<tr>
    <td>{{ $beat->id }}</td>
    <td>{{ $beat->beat_name }}</td>
    <td>
        <span class="badge  {{ $beat->is_active == 1 ? 'bg-success':'bg-danger' }}">{{ $beat->is_active == 1 ? 'Active':'Inactive' }}</span>
    </td>
    <td>
        <button
            type="button"
            class="btn btn-primary"
            onclick="showEditForm('{{ $beat }}','{{ url('/updateBeatById/')}}/{{ $beat->id }}')"
        >
            <i class="bi bi-pencil-square"></i>
        </button>
        <button
            type="button"
            class="btn btn-danger"
            onclick="showDeleteConfirmationDialog('{{ $beat->id }}','{{ url('/deleteBeatById/')}}/{{ $beat->id }}')"
        >
            <i class="bi bi-trash-fill"></i>
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="4" class="text-center">No records found</td>
</tr>
@endforelse