<x-layout :currentPage="$currentPage">
    <div>
        <button class="btn btn-primary mt-2 mb-2" onclick="printShipment()">
            Print Shipment
        </button>
        <input
            type="text"
            name=""
            id="datepicker"
            placeholder="Search"
            style="float: right; margin-top: 10px; width: unset"
            class="form-control"
        />
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <!-- Table with stripped rows -->
                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                id="gridCheck1"
                                                onchange="toggleMaster(event)"
                                            />
                                        </div>
                                    </th>
                                    <th>Invoice No.</th>
                                    <th>Customer Name</th>
                                    <th>Beat Name</th>
                                    <th>Invoice Date</th>
                                    <th>Ship Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.shipments.single',['shipments'=>$shipments])
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.shipments.scripts')
</x-layout>
