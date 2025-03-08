<div class="card">
    <div class="card-body">
      <h5 class="card-title">Distributor details</h5>

      <!-- General Form Elements -->
      <form class="row g-3" action="{{ route('updateCompany') }}" method="POST" enctype="multipart/form-data">
          @csrf
        <div class="col-12">
          <label for="inputText" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required value="{{ $distributor->name }}">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
        @enderror                      
        </div>
        <div class="col-12">
          <label for="inputText" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" required value="{{ $distributor->address }}">
            @error('address')
            <span class="text-danger">{{ $message }}</span>
        @enderror                      
        </div>
        <div class="col-12">
          <label for="inputText" class="form-label">GST Number</label>
            <input type="text" name="gst_number" class="form-control" required value="{{ $distributor->gst_number }}">
            @error('gst_number')
            <span class="text-danger">{{ $message }}</span>
        @enderror                      
        </div>                  
        <div class="col-12">
          <label for="inputText" class="form-label">Phone Number</label>
            <input type="text" name="phone_number" class="form-control" value="{{ $distributor->phone_number }}">
            @error('phone_number')
            <span class="text-danger">{{ $message }}</span>
        @enderror                      

        </div>                  
        <div class="col-12">
          <label class="form-label"></label>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

      </form><!-- End General Form Elements -->

    </div>
  </div>
