<x-layout :currentPage="$currentPage">
    <section class="section">
        <div class="row">
          <div class="col-lg-6">
  
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Distributor details</h5>
  
                <!-- General Form Elements -->
                <form class="row g-3" action="{{ route('updateCompany') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                  <div class="col-12">
                    <label for="inputText" class="form-label">Name</label>
                      <input type="text" name="name" class="form-control" required value="{{ $distributor->name }}">
                      @error('name')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror                      
                  </div>
                  <div class="col-12">
                    <label for="inputText" class="form-label">Address</label>
                      <input type="text" name="address" class="form-control" required value="{{ $distributor->address }}">
                      @error('address')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror                      
                  </div>
                  <div class="col-12">
                    <label for="inputText" class="form-label">GST Number</label>
                      <input type="text" name="gst_number" class="form-control" required value="{{ $distributor->gst_number }}">
                      @error('gst_number')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror                      
                  </div>                  
                  <div class="col-12">
                    <label for="inputText" class="form-label">Phone Number</label>
                      <input type="text" name="phone_number" class="form-control" value="{{ $distributor->phone_number }}">
                      @error('phone_number')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror                      

                  </div>                  
                  <div class="col-12">
                    <label class="form-label"></label>
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
  
                </form><!-- End General Form Elements -->
  
              </div>
            </div>
  
          </div>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Measurements</h5>
                <button class="btn btn-primary" onclick="showCreateForm()">Add New</button>                
              <!-- Bordered Table -->
              <table class="table table-bordered mt-3">
                <thead>
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($measurements as $m)
                  <tr>
                    <td>{{ $m->name }}</td>
                    <td>{{$m->quantity}}</td>
                    <td>
                      <button
                          type="button"
                          class="btn btn-primary"   
                          onclick="showEditForm('{{ $m }}','{{ url('/updateMeasurementById/')}}/{{ $m->id }}')"                                                 
                      >
                          <i class="bi bi-pencil-square"></i>
                      </button>
                      <button
                          type="button"
                          class="btn btn-danger"
                          onclick="showDeleteConfirmationDialog('{{ $m->id }}','{{ url('/deleteMeasurementById/')}}/{{ $m->id }}')"                          
                      >
                          <i class="bi bi-trash-fill"></i>
                      </button>
                  </td>                    
                  </tr>
                    
                  @endforeach
                </tbody>
              </table>
              <!-- End Bordered Table -->

              </div>
            </div>
          </div>

        </div>
      </section>
      <div class="modal fade" id="meaModal" tabindex="-1">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal-title"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- General Form Elements -->
              <!-- Vertical Form -->
              <form class="row g-3" id="mea_form" action="#" method="post">
                <div class="col-12">
                  <label for="mea_name" class="form-label">Name</label>
                  <input type="text" class="form-control" id="mea_name" name="mea_name" required>
                </div>
                <div class="col-12">
                    <label for="mea_quantity" class="form-label">Quantity</label>
                    <input type="text" class="form-control" id="mea_quantity" name="mea_quantity" required>
                  </div>                
                  <input type="hidden" id="store_url" value="{{ route('createMeasurement') }}">
                  <input type="hidden" id="edit_url" value="">


              </form><!-- Vertical Form -->               
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="submitMeasurementForm()">Save changes</button>
            </div>
          </div>
        </div>
      </div><!-- End Basic Modal-->        

      @if (session('success'))
      <script>
Swal.fire({
  title: 'Success!',
  text: 'Distributor Details updated.',
  icon: 'success',
  confirmButtonText: 'OK'
});            

      </script>
  @endif

  <script>
function showEditForm(measurement,edit_url){
    $("#edit_url").val('');
    $("#mea_form")[0].reset();
    let measurementJson = JSON.parse(measurement)

                    $("#modal-title").html('Edit Measurement');
                    $("#edit_url").val(edit_url);
                    $("#mea_name").val(measurementJson.name);
                    $("#mea_quantity").val(measurementJson.quantity);
                    $("#meaModal").modal('show');      

}

function showCreateForm(){
        $("#edit_url").val('');
        $("#mea_form")[0].reset();

        $("#modal-title").html('Create Measurement');
        $("#meaModal").modal('show');
    }

function submitMeasurementForm(){
  let form = $("#mea_form").serializeArray();

let isEdit = $("#edit_url").val();
let url = $("#store_url").val();
if(isEdit.length > 0){
    url = $("#edit_url").val();
}  

let data = {
    name: form.find(item => item.name === 'mea_name').value,
    quantity: form.find(item => item.name === 'mea_quantity').value,
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
                text: "Do you want to delete this Measurement?",
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