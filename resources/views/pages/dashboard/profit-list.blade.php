<x-layout :currentPage="$currentPage">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Profit List</h5>
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
</x-layout>