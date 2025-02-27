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
            <a class="nav-link {{ $currentPage=='invoicesCreate'?'':'collapsed' }}" href="{{ route('invoiceGenerate') }}">
              <i class="bi bi-question-circle"></i>
              <span>Generate Invoice</span>
            </a>
          </li><!-- End F.A.Q Page Nav -->
          <li class="nav-item">
            <a class="nav-link {{ $currentPage=='invoicesList'?'':'collapsed' }}" href="{{ route('invoiceList') }}">
              <i class="bi bi-question-circle"></i>
              <span>Invoice List</span>
            </a>
          </li><!-- End F.A.Q Page Nav -->
        
      <li class="nav-item">
        <a class="nav-link {{ $currentPage=='shipmentList'?'':'collapsed' }}" href="{{ route('shipmentList') }}">
          <i class="bi bi-envelope"></i>
          <span>Shipment Summary</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='inventory'?'':'collapsed' }}" href="{{ route('inventory.index') }}">
          <i class="bi bi-card-list"></i>
          <span>Inventory Listing</span>
        </a>
      </li><!-- End Register Page Nav -->
      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='inventoryHistory'?'':'collapsed' }}" href="{{ route('inventoryHistory') }}">
          <i class="bi bi-card-list"></i>
          <span>Inventory History</span>
        </a>
      </li><!-- End Register Page Nav -->
      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='products'?'':'collapsed' }}" href="{{ route('products.index') }}">
          <i class="bi bi-card-list"></i>
          <span>Manage Products</span>
        </a>
      </li><!-- End Register Page Nav -->      

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='distributor'?'':'collapsed' }}" href="{{ route('distributor.index') }}">
          <i class="bi bi-card-list"></i>
          <span>Manage Distributor</span>
        </a>
      </li><!-- End Register Page Nav -->      

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='beats'?'':'collapsed' }}" href="{{ route('beats.index') }}">
          <i class="bi bi-card-list"></i>
          <span>Manage Beats</span>
        </a>
      </li><!-- End Register Page Nav -->      

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='customers'?'':'collapsed' }}" href="{{ route('customer.index') }}">
          <i class="bi bi-card-list"></i>
          <span>Manage Customers</span>
        </a>
      </li><!-- End Register Page Nav -->            


    </ul>

  </aside><!-- End Sidebar-->