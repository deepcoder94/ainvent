<div
class="modal fade"
id="ExtralargeModal"
tabindex="-1"
aria-hidden="true"
style="display: none"
>
<div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Products</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
        </div>
        <div class="modal-body">
            <form action="#" method="POST" id="gstProductsForm">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Item Description</th>
                            <th>Code</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Unit Price</th>
                            <th>Discount</th>
                            <th>Taxable Amt</th>
                            <th>Tax Rate</th>
                            <th>Other Charges</th>
                            <th>Total</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody id="gstproduct-tbody"></tbody>
                </table>
            </form>
        </div>
        <div class="modal-footer">
            <button
                type="button"
                class="btn btn-warning"
                data-bs-dismiss="modal"
            >
                Close
            </button>
            <button
                type="button"
                class="btn btn-success"
                onclick="addGstProduct()"
            >
                Add Product
            </button>
            <button
                type="button"
                class="btn btn-dark"
                onclick="submitGstProductForm()"
            >
                Save changes
            </button>
        </div>
    </div>
</div>
</div>