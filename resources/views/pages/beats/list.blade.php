<x-layout :currentPage="$currentPage">
    
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Beats List</h5>
                        <button class="btn btn-primary" onclick="showCreateForm()">Add New</button>
                        <!-- Table with stripped rows -->
                        <table class="table datatable mt-1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
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
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="beatModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal-title"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- General Form Elements -->
              <!-- Vertical Form -->
              <form class="row g-3" id="beat_form" action="#" method="post">
                <div class="col-12">
                  <label for="beat_name" class="form-label">Beat Name</label>
                  <input type="text" class="form-control" id="beat_name" name="beat_name" required>
                </div>
                <div class="col-12">
                    <label for="beat_address" class="form-label">Beat Address</label>
                    <input type="text" class="form-control" id="beat_address" name="beat_address" required>
                  </div>                
                  <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="beat_active" name="beat_active">
                        <label class="form-check-label" for="beat_active">Is Active</label>
                      </div>                  
    
                  </div>                      
                  <input type="hidden" id="store_url" value="{{ route('beats.store') }}">
                  <input type="hidden" id="edit_url" value="">


              </form><!-- Vertical Form -->               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="submitBeatForm()">Save changes</button>
            </div>
          </div>
        </div>
      </div><!-- End Basic Modal-->        
      <script>
function showEditForm(beat,edit_url){
    $("#edit_url").val('');
    $("#beat_form")[0].reset();
    let beatJson = JSON.parse(beat)

                    $("#modal-title").html('Edit Beat');
                    $("#edit_url").val(edit_url);
                    $("#beat_name").val(beatJson.beat_name);
                    $("#beat_address").val(beatJson.beat_address);
                    if(beatJson.is_active == 1){
                        $("#beat_active").prop('checked', true);
                    }
                    else{
                        $("#beat_active").prop('checked', false);

                    }
                    $("#beatModal").modal('show');      

}

    function showCreateForm(){
        $("#edit_url").val('');
        $("#beat_form")[0].reset();

        $("#modal-title").html('Create Beat');
        $("#beatModal").modal('show');
    }

    function submitBeatForm(){
        let form = $("#beat_form").serializeArray();

        let isEdit = $("#edit_url").val();
        let url = $("#store_url").val();
        if(isEdit.length > 0){
            url = $("#edit_url").val();
        }  
        
        let data = {
            beat_name: form.find(item => item.name === 'beat_name').value,
            beat_address: form.find(item => item.name === 'beat_address').value,
            is_active: $("#beat_active").prop("checked")?1:0
        };
        

        $.ajax({
            url: url,  // The URL defined in your routes
            type: 'POST',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
            },
            dataType: 'json',
            data: data,
            success: function(response) {     
                if(response.success){
                    alert(response.message)
                    location.reload()
                }                       
                else if(!response.success){
                    alert(response.message)
                }
            },
            error: function(xhr, status, error) {
                alert(error)                
            }
    });
        
    }

    function showDeleteConfirmationDialog(id,url){
// Show SweetAlert confirmation dialog
Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to delete this Beat? This will delete all customers associated with this Beat",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, proceed with AJAX request to delete the resource
                    $.ajax({
                        url: url,  // Your route to delete the resource
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',  // CSRF token for security
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', response.message, 'success');
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error!', 'There was an issue deleting the resource.', 'error');
                        }
                    });                                        
                } 
                else {
                    
                    // If the user canceled, do nothing
                }
            });        
    }

      </script>
</x-layout>
