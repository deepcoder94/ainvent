<x-layout :currentPage="$currentPage">
    <section class="section" id="profitSection" style="display:none">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Profit List</h5>
                        <button class="btn btn-warning mt-2 mb-2" onclick="exportProducts()">
                            <i class="bi bi-download me-1"></i> Export 
                        </button>        
                        
                        <div class="row flex" style="justify-content: flex-end">
                            <div class="col-lg-2 mb-2">
                                <label for="">Per Page</label>
                                <select id="perPage" class="form-control" onchange="paginateRecords()">
                                    @for ($i = $perPage; $i <= 100; $i+=$perPage)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor                                                                       
                                </select>
                            </div>
                            <div class="col-lg-2 mb-2">
                                <label for="">Current Page</label>
                                <select id="currentPage" class="form-control" onchange="paginateRecords()">
                                    @for ($i = 1; $i <= $totalpagnums; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor                                   
                                </select>
                            </div>                            
                        </div>
                        
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Invoice Number</th>
                                    <th>Profit Amount</th>
                                </tr>
                            </thead>
                            <tbody id="salesbody">
                                @include('pages.profit.single',['groupedData'=>$groupedData])
                            </tbody>
                        </table>                                                
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('pages.profit.scripts')

</x-layout>