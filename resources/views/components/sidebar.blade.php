  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link {{ $currentPage=='dashboard'?'':'collapsed' }}" href="{{ route('dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->
      <li class="nav-item">
        <a class="nav-link {{ $currentPage=='salesList'?'':'collapsed' }}" href="{{ route('sales.list') }}">
          <i class="bi bi-grid"></i>
          <span>Sales List</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->      
      <li class="nav-item">
        <a class="nav-link {{ $currentPage=='profitList'?'':'collapsed' }}" href="{{ route('profit.list') }}">
          <i class="bi bi-grid"></i>
          <span>Profit List</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->      
          <li class="nav-item">
            <a class="nav-link {{ $currentPage=='invoiceRequestGenerate'?'':'collapsed' }}" href="{{ route('invoice.request.create') }}">
              <i class="bi bi-clipboard-plus"></i>
              <span>Generate Invoice Request</span>
            </a>
          </li><!-- End F.A.Q Page Nav -->          
          <li class="nav-item">
            <a class="nav-link {{ $currentPage=='invoiceRequestList'?'':'collapsed' }}" href="{{ route('invoice.request.list') }}">
              <i class="bi bi-clipboard-plus"></i>
              <span>Invoice Requests</span>
            </a>
          </li><!-- End F.A.Q Page Nav -->          
          <li class="nav-item">
            <a class="nav-link {{ $currentPage=='invoiceGenerateNew'?'':'collapsed' }}" href="{{ route('invoice.create.list') }}">
              <i class="bi bi-clipboard-plus"></i>
              <span>Generate Invoice</span>
            </a>
          </li><!-- End F.A.Q Page Nav -->          
          <li class="nav-item">
            <a class="nav-link {{ $currentPage=='invoicesList'?'':'collapsed' }}" href="{{ route('invoice.list') }}">
              <i class="bi bi-clipboard-data"></i>
              <span>Invoice List</span>
            </a>
          </li><!-- End F.A.Q Page Nav -->
      <li class="nav-item">
        <a class="nav-link {{ $currentPage=='shipmentList'?'':'collapsed' }}" href="{{ route('shipment.list') }}">
          <i class="bi bi-receipt"></i>
          <span>Shipment Summary</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='inventory'?'':'collapsed' }}" href="{{ route('inventory.list') }}">
          <i class="bi bi-layers-fill"></i>
          <span>Inventory Listing</span>
        </a>
      </li><!-- End Register Page Nav -->
      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='inventoryHistory'?'':'collapsed' }}" href="{{ route('inventory.history.list') }}">
          <i class="bi bi-table"></i>
          <span>Inventory History</span>
        </a>
      </li><!-- End Register Page Nav -->
      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='products'?'':'collapsed' }}" href="{{ route('product.list') }}">
          <i class="bi bi-basket2-fill"></i>
          <span>Manage Products</span>
        </a>
      </li><!-- End Register Page Nav -->      

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='distributor'?'':'collapsed' }}" href="{{ route('distributor.index') }}">
          <i class="bi bi-briefcase-fill"></i>
          <span>Manage Distributor</span>
        </a>
      </li><!-- End Register Page Nav -->      

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='beats'?'':'collapsed' }}" href="{{ route('beats.list') }}">
          <i class="bi bi-people-fill"></i>
          <span>Manage Beats</span>
        </a>
      </li><!-- End Register Page Nav -->      

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='customers'?'':'collapsed' }}" href="{{ route('customer.list') }}">
          <i class="bi bi-person-fill"></i>
          <span>Manage Customers</span>
        </a>
      </li><!-- End Register Page Nav -->            

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='customer_payments'?'':'collapsed' }}" href="{{ route('payment.list') }}">
          <i class="bi bi-cash-stack"></i>
          <span>Manage Payments</span>
        </a>
      </li><!-- End Register Page Nav -->                  

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='payment_history'?'':'collapsed' }}" href="{{ route('payment.history.list') }}">
          <i class="bi bi-cash-stack"></i>
          <span>Payments History</span>
        </a>
      </li><!-- End Register Page Nav -->                        

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='returns'?'':'collapsed' }}" href="{{ route('return.list') }}">
          <i class="bi bi-box-arrow-in-up"></i>
          <span>Manage Returns</span>
        </a>
      </li><!-- End Register Page Nav -->                        

    </ul>

  </aside><!-- End Sidebar-->