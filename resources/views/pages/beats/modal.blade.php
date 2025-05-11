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
              <input type="hidden" id="edit_id" value="">


          </form><!-- Vertical Form -->               
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="submitBeatForm()">Save changes</button>
        </div>
      </div>
    </div>
  </div><!-- End Basic Modal-->  