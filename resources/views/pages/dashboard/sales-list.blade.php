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
                                @include('pages.dashboard.sales-list-single',['beats'=>$beats,'payments'=>$payments])
                            </tbody>
                        </table>                        
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function getSales(){
            let datepicker = $("#datepicker").val();
            let selectedBeat = $("#selectedBeat").val();

            $.ajax({
                url: "{{ route('searchSales') }}",  // The URL defined in your routes
                type: 'GET',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
                },
                data: { date:datepicker.length>0?datepicker:'all',selectedBeat:selectedBeat.length>0?selectedBeat:'all' },
                success: function(response) {     
                    $("#salesbody").html(response)                    
                },
                error: function(xhr, status, error) {
                    console.log(error);
                    
                }
            });                        

        }
    </script>
</x-layout>