<x-layout :currentPage="$currentPage">
    
    <div id="beatPage" style="display:none">
    <div class="mt-2 mb-2">
        <button
        class="btn btn-primary"
        onclick="showCreateForm()"
    >
        Add New
    </button>


    </div>    
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body tablecontainer">
                        <h5 class="card-title">Beats List</h5>
                        <!-- Table with stripped rows -->
                        <table class="table mt-1">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('pages.beats.single',['beats'=>$beats])
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
        
    </div>
    
    @include('pages.beats.modal')

    @include('pages.beats.scripts')
</x-layout>
