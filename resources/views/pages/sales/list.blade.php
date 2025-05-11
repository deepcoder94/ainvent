<x-layout :currentPage="$currentPage">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sales List</h5>
                        <div class="row mt-2 mb-3">
                            <div class="col-lg-3">
                                <input type="text" class="form-control" id="datepicker" placeholder="Search by date" onchange="getSales()">
                            </div>
                            <div class="col-lg-3">
                                <select id="selectedBeat" class="form-control sel2input" onchange="getSales()">
                                    <option value="">Select Beat</option>
                                    @foreach ($beats as $b)
                                        <option value="{{ $b->id }}">{{ $b->beat_name }}</option>
                                    @endforeach
                                </select>
                            </div>                            
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Beat Name</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody id="salesbody">
                                @include('pages.sales.single',['beats'=>$beats,'payments'=>$payments])
                            </tbody>
                        </table>                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
   @include('pages.sales.scripts')
</x-layout>