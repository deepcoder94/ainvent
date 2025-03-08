<div class="modal fade" id="inventoryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-title"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- General Form Elements -->
          <!-- Vertical Form -->
          <form class="row g-3" id="inventory_form" action="#" method="post">
            <table class="table table-bordered" id="invProds">
                <tr id="inv_rec_1">
                    <td>
                        <select name="inv_product[]" class="form-control">
                            <option value="">Select Product..</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}">{{ $p->product_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                    <select name="inv_mea[]" class="form-control">
                            <option value="">Select Type..</option>
                            @foreach ($measurements as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>                            
                    </td>
                    <td>
                        <input type="text" name="inv_qty[]" class="form-control" placeholder="Quantity">
                    </td>
                    <td>
                      <input type="text" name="inv_buying_price[]" class="form-control" placeholder="Buy Price">
                  </td>                    
                    <td>
                        <i class="bi bi-plus-square-fill text-success" style="font-size: 24px;cursor:pointer" onclick="addInvProduct()"></i>
                    </td>
                    <td>
                    </td>
                </tr>
            </table>

          </form><!-- Vertical Form -->               
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="submitInvForm()">Save changes</button>
        </div>
      </div>
    </div>
  </div><!-- End Basic Modal-->        
