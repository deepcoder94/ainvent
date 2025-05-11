@foreach ($measurements as $m)
<tr>
  <td>{{ $m->name }}</td>
  <td>{{$m->quantity}}</td>
  <td>
    <button
        type="button"
        class="btn btn-primary"   
        onclick="showEditForm('{{ $m->id }}')"                                                 
    >
        <i class="bi bi-pencil-square"></i>
    </button>
    <button
        type="button"
        class="btn btn-danger"
        onclick="showDeleteConfirmationDialog('{{ $m->id }}')"                          
    >
        <i class="bi bi-trash-fill"></i>
    </button>
</td>                    
</tr>
  
@endforeach
