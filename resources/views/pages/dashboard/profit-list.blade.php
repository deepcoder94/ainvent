<x-layout :currentPage="$currentPage">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Profit List</h5>
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
                                @include('pages.dashboard.profit-list-single',['profits'=>$profits])
                            </tbody>
                        </table>                                                
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function paginateRecords(){
            let currentPage = $("#currentPage").val();
            let perPage = $("#perPage").val();
            let url = '{{ route('profitList') }}';
            $.ajax({
            url: url, // The URL defined in your routes
            type: "GET",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ), // CSRF Token
            },
            data:{
                currentPageNum:currentPage,
                perPage:perPage
            },
            success: function (response) {
                $("#salesbody").html(response)                
            },
            error: function (xhr, status, error) {},
        });

        }
    </script>
</x-layout>