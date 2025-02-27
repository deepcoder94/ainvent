<x-layout :currentPage="$currentPage">
    
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Inventory History</h5>
                        <!-- Table with stripped rows -->
                        <table class="table table-bordered mt-1">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Measurement</th>
                                    <th>Total Quantity</th>
                                    <th>Stock In / Out</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inventoryHistory as $i)
                                <tr>
                                    <td>{{ $i->product->product_name }}</td>
                                    <td>{{ $i->measurement->name }}</td>
                                    <td>{{ $i->stock_out_in }}</td>
                                    <td>
                                        @if($i->stock_action == 'add')
                                            <span class="badge bg-success">Added</span>                                        
                                        @else
                                            <span class="badge bg-danger">Deducted</span>   
                                        @endif                                        
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($i->created_at)->format('d-m-Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>
        
      </x-layout>
