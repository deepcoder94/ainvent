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
        <a class="nav-link {{ $currentPage=='profitList'?'':'collapsed' }}" href="{{ route('profitList') }}">
          <i class="bi bi-grid"></i>
          <span>Profit List</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->      
      
      <li class="nav-item">
        <a class="nav-link {{ $currentPage=='salesList'?'':'collapsed' }}" href="{{ route('salesList') }}">
          <i class="bi bi-grid"></i>
          <span>Sales List</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->      

          <li class="nav-item">
            <a class="nav-link {{ $currentPage=='invoicesCreate'?'':'collapsed' }}" href="{{ route('invoiceGenerate') }}">
              <i class="bi bi-clipboard-plus"></i>
              <span>Generate Invoice</span>
            </a>
          </li><!-- End F.A.Q Page Nav -->
          <li class="nav-item">
            <a class="nav-link {{ $currentPage=='gstInvoice'?'':'collapsed' }}" href="{{ route('showGstInvoiceForm') }}">
              <i class="bi bi-clipboard-plus"></i>
              <span>Generate GST Invoice</span>
            </a>
          </li><!-- End F.A.Q Page Nav -->
          <li class="nav-item">
            <a class="nav-link {{ $currentPage=='newInvoice'?'':'collapsed' }}" href="{{ route('showNewInvoiceForm') }}">
              <i class="bi bi-clipboard-plus"></i>
              <span>Generate New Invoice</span>
            </a>
          </li><!-- End F.A.Q Page Nav -->
          <li class="nav-item">
            <a class="nav-link {{ $currentPage=='invoicesList'?'':'collapsed' }}" href="{{ route('invoiceList') }}">
              <i class="bi bi-clipboard-data"></i>
              <span>Invoice List</span>
            </a>
          </li><!-- End F.A.Q Page Nav -->
          <li class="nav-item">
            <a class="nav-link {{ $currentPage=='gstInvoiceList'?'':'collapsed' }}" href="{{ route('gstInvoiceList') }}">
              <i class="bi bi-clipboard-data"></i>
              <span>GST Invoice List</span>
            </a>
          </li><!-- End F.A.Q Page Nav -->        
      <li class="nav-item">
        <a class="nav-link {{ $currentPage=='shipmentList'?'':'collapsed' }}" href="{{ route('shipmentList') }}">
          <i class="bi bi-receipt"></i>
          <span>Shipment Summary</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='inventory'?'':'collapsed' }}" href="{{ route('inventory.index') }}">
          <i class="bi bi-layers-fill"></i>
          <span>Inventory Listing</span>
        </a>
      </li><!-- End Register Page Nav -->
      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='inventoryHistory'?'':'collapsed' }}" href="{{ route('inventoryHistory') }}">
          <i class="bi bi-table"></i>
          <span>Inventory History</span>
        </a>
      </li><!-- End Register Page Nav -->
      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='products'?'':'collapsed' }}" href="{{ route('products.index') }}">
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
        <a class="nav-link  {{ $currentPage=='beats'?'':'collapsed' }}" href="{{ route('beats.index') }}">
          <i class="bi bi-people-fill"></i>
          <span>Manage Beats</span>
        </a>
      </li><!-- End Register Page Nav -->      

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='customers'?'':'collapsed' }}" href="{{ route('customer.index') }}">
          <i class="bi bi-person-fill"></i>
          <span>Manage Customers</span>
        </a>
      </li><!-- End Register Page Nav -->            

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='customer_payments'?'':'collapsed' }}" href="{{ route('paymentsList') }}">
          <i class="bi bi-cash-stack"></i>
          <span>Manage Payments</span>
        </a>
      </li><!-- End Register Page Nav -->                  

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='payment_history'?'':'collapsed' }}" href="{{ route('paymentHistory') }}">
          <i class="bi bi-cash-stack"></i>
          <span>Payments History</span>
        </a>
      </li><!-- End Register Page Nav -->                        

      <li class="nav-item">
        <a class="nav-link  {{ $currentPage=='returns'?'':'collapsed' }}" href="{{ route('showReturnForm') }}">
          <i class="bi bi-box-arrow-in-up"></i>
          <span>Manage Returns</span>
        </a>
      </li><!-- End Register Page Nav -->                        

    </ul>

  </aside><!-- End Sidebar-->