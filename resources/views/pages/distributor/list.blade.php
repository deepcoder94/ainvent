<x-layout :currentPage="$currentPage">
    <section class="section" id="distriSection" style="display:none">
        <div class="row">
            <div class="col-lg-6">
                @include('pages.distributor.details',['distributor'=>$distributor])
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Measurements</h5>
                        <button
                            class="btn btn-primary"
                            onclick="showCreateForm()"
                        >
                            Add New
                        </button>
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
                                @include('pages.distributor.measurement_single',['measurements'=>$measurements])
                            </tbody>
                        </table>
                        <!-- End Bordered Table -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.distributor.modal') @if (session('success'))
    <script>
        Swal.fire({
            title: "Success!",
            text: "Distributor Details updated.",
            icon: "success",
            confirmButtonText: "OK",
        });
    </script>
    @endif
    @include('pages.distributor.scripts')
</x-layout>
