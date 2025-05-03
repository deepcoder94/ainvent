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
    <script>
        function exportProducts(){
            $.ajax({
            url: "{{ route('profitExport') }}", // The route to your export method
            type: 'GET',
            headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ), // CSRF Token
                    },
            success: function(response) {
                window.location.href = response.url_path;
            },
            error: function(xhr, status, error) {
                alert('There was an error exporting the CSV. Please try again.');
            }
        });            
        }
        
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
        
   // Function to show the login popup with username and password fields
        function showLoginPopup() {
            Swal.fire({
                title: 'Login to Continue',
                html: `
                    <input id="password" class="swal2-input" type="password" placeholder="Password">
                `,
                confirmButtonText: 'Login',
                preConfirm: () => {
                    const password = document.getElementById('password').value;
                    
                    // Simple validation: check if both fields are filled
                    if (!password) {
                        Swal.showValidationMessage('Both fields are required');
                        return false;
                    }
                    return { password };
                }
            }).then(result => {
                if (result.isConfirmed) {
                    const { password } = result.value;

                    // Optionally, send these credentials to the server via AJAX
                    validateLogin(password);
                }
            });
        }

        // Validate the login credentials (can be done via AJAX)
        function validateLogin(password) {
            // Simulate a login check (replace with your server-side validation)
            if ( password === "4561") {
                Swal.fire('Login Successful', 'You can now access the page.', 'success');
                document.getElementById("profitSection").style.display = "block"; // Show actual content
            } else {
                Swal.fire('Invalid Credentials', 'Please check your username and password.', 'error');
                showLoginPopup(); // Re-show the popup for retry
            }
        }

        // Show the login popup as soon as the page loads
        window.onload = function() {
            showLoginPopup();
        };        
    </script>
</x-layout>