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
