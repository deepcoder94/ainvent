<x-layout :currentPage="$currentPage">
    <section class="section">
        <form action="#" method="POST" id="gst_invoice_form">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">GST Invoice</h5>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="">Invoice number</label>
                                <input
                                    type="text"
                                    name="invoice_no"
                                    class="form-control"
                                />
                            </div>
                            <div class="col-lg-6">
                                <label for="">Invoice Date</label>
                                <input
                                    type="text"
                                    name="invoice_date"
                                    class="form-control"
                                    id="datepicker"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Party Detail</h6>
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <strong>Supplier Detail</strong>
                                <div class="mt-2">
                                    <input
                                        type="text"
                                        name="supplier_name"
                                        placeholder="Name"
                                        class="form-control"
                                    />
                                    <input
                                        type="text"
                                        name="supplier_gstin"
                                        placeholder="GSTIN"
                                        class="form-control mt-2"
                                    />
                                    <input
                                        type="text"
                                        name="supplier_address"
                                        placeholder="Address"
                                        class="form-control mt-2"
                                    />
                                    <input
                                        type="text"
                                        name="supplier_phone"
                                        placeholder="Phone"
                                        class="form-control mt-2"
                                    />
                                </div>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <strong>Reciepent Detail</strong>
                                <div class="mt-2">
                                    <input
                                        type="text"
                                        name="recepent_name"
                                        placeholder="Name"
                                        class="form-control"
                                    />
                                    <input
                                        type="text"
                                        name="recepent_gstin"
                                        placeholder="GSTIN"
                                        class="form-control mt-2"
                                    />
                                    <input
                                        type="text"
                                        name="recepent_address"
                                        placeholder="Address"
                                        class="form-control mt-2"
                                    />
                                    <input
                                        type="text"
                                        name="recepent_phone"
                                        placeholder="Phone"
                                        class="form-control mt-2"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Product Details</h6>
                        <button
                            class="btn btn-primary"
                            onclick="showProductDetail()"
                            type="button"
                        >
                            Add Products
                        </button>
                        <form action="#" method="POST" id="gstProductsForm">

                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Description |<br/>HSN Code</th>
                                    <th>Qty | <br/>Unit Price</th>
                                    <th>Taxable Amt</th>
                                    <th>Tax Rate (GST,CESS<br/>State, Non Advol.)</th>
                                    <th>Other Charges</th>
                                    <th>Total</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody id="allProductstd"></tbody>
                        </table>
                        </form>
                        <h6 class="card-title">GST Information</h6>
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>Tax'ble Amt</th>
                                    <th>CGST Amt | <br/>SGST Amt</th>
                                    <th>IGST Amt</th>
                                    <th>CESS Amt | <br/>State CESS</th>
                                    <th>Discount</th>
                                    <th>Other Charges</th>
                                    <th>Round off Amt</th>
                                    <th>Tot Inv. Amt</th>
                                </tr>    
                            </thead>
                            <tbody>
                                <tr id="gst_calc_tbody">
                                    <td>
                                        <input type="text" name="gst_taxable_amt" id="gst_taxable_amt" class="form-control" value="0.00">
                                    </td>
                                    <td>
                                        <input type="text" name="gst_cgst" id="gst_cgst" class="form-control" value="0.00">
                                        <input type="text" name="gst_sgst" id="gst_sgst" class="form-control mt-1" value="0.00">
                                    </td>
                                    <td>
                                        <input type="text" name="gst_igst" id="gst_igst" class="form-control" value="0.00">
                                    </td>
                                    <td>
                                        <input type="text" name="gst_cess" id="gst_cess" class="form-control" value="0.00">
                                        <input type="text" name="gst_state_cess" id="gst_state_cess" class="form-control mt-1" value="0.00">
                                    </td>
                                    <td>
                                        <input type="text" name="gst_discount" id="gst_discount" class="form-control" value="0.00">
                                    </td>
                                    <td>
                                        <input type="text" name="gst_other_charges" id="gst_other_charges" class="form-control" value="0.00">
                                    </td>
                                    <td>
                                        <input type="text" name="gst_roundoff" id="gst_roundoff" class="form-control" value="0.00" onkeyup="calculateGstTotal()">
                                    </td>
                                    <td>
                                        <input type="text" name="gst_total_inv" id="gst_total_inv" class="form-control" value="0.00">
                                    </td>
                                </tr>
    
                            </tbody>
                        </table>
                    </div>
                </div>
                <button class="btn btn-primary" type="button" onclick="generateGstInvoice()">Generate GST Invoice</button>

            </div>
        </div>
    </form>
    </section>

    @include('pages.generate-gst.add-single-product-modal')
    @include('pages.generate-gst.script')
</x-layout>
