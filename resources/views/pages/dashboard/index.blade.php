
<x-layout :currentPage="$currentPage">
    <section class="section dashboard">
        <div class="row">
  
          <!-- Left side columns -->
          <div class="col-lg-12">
            <div class="row">
  
              <!-- Sales Card -->
              <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">  
                  <div class="card-body">
                    <h5 class="card-title">Sale Payments <span>| Today</span></h5>
  
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-cart"></i>
                      </div>
                      <div class="ps-3">
                        <h6>{{ $total_pay }}</h6>  
                      </div>
                    </div>
                  </div>
  
                </div>
              </div><!-- End Sales Card -->
    
              <!-- Customers Card -->
              <div class="col-xxl-4 col-xl-12">
  
                <div class="card info-card customers-card">
    
                  <div class="card-body">
                    <h5 class="card-title">Sales By Beat <span>| Today</span></h5>
                    <table class="table table-hover mt-3">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Beat Name</th>
                          <th scope="col">Total Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse ($beatsSum as $i => $beat)
                        <tr>
                          <td>{{ ++$i }}</td>
                          <td>{{ $beat['beat_name'] }}</td>
                          <td>{{ $beat['total_amount'] }}</td>
                        </tr>
                          
                        @empty
                          <tr>
                            <td colspan="3">No data available</td>
                          </tr>
                        @endforelse
                      </tbody>
                    </table>    
                  </div>
                </div>
  
              </div><!-- End Customers Card -->
    
            </div>
          </div><!-- End Left side columns -->
  
  
        </div>
      </section>
</x-layout>