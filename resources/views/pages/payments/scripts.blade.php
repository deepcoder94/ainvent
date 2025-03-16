<script>
function showCreateForm(){
    $("#edit_url").val('');
    $("#customer_form")[0].reset();

    $("#modal-title").html('Create Customer');
    $("#customerModal").modal('show');
}

function confirmRecord(customer_id){
    let invtotal = $(`.btn_${customer_id}`).data("invoicetotal");
    let duetotal = $(`.btn_${customer_id}`).data("duetotal");
    let invoiceid = $(`.btn_${customer_id}`).data("invoiceid");
    let customerid = $(`.btn_${customer_id}`).data("customerid");
    
    let updateUrl = '{{ url('paymentsUpdate') }}/'+customer_id

    let paid_total = $(`#paid_total_${customer_id}`).val();
    paid_total = parseFloat(paid_total)
    
    let total = invtotal+duetotal;
    let newdue = total-paid_total
                    
    $.ajax({
        url: updateUrl,  // The URL defined in your routes
        type: 'POST',
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
        },
        dataType: 'json',
        data: { due:newdue,isBeatCustomer:1,invoiceid:invoiceid,paid_total:paid_total,customerid:customerid },
        success: function(response) {
            if(response.success){
                alert(response.message)
                location.reload();
            }
            else if(!response.success){
                alert(response.message)
            }
        },
        error: function(xhr, status, error) {
            alert(error.message)
        }
    });
}

function getPaymentsByBeat(){
    let beatId = $("#beat_select").val();
    let url = "{{ url('getPaymentsByBeat') }}/"+beatId;
    $.ajax({
        url: url,  // The URL defined in your routes
        type: 'GET',
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
        },
        success: function(response) {
            $("#paymentsTable").html(response)
        },
        error: function(xhr, status, error) {
            alert(error.message)
        }
    });
    
}

function searchByInvoice(){
    let invoiceNumber = $("#invoice_no").val();
    if(invoiceNumber.length == 0){
            return;
    }
    let url = "{{ url('getPaymentsByInvoiceId') }}/"+invoiceNumber;
    $(".no-record-inv-search-loader").css('display','contents');
    $(".no-record-inv-search").css('display','none');
    $.ajax({
        url: url,  // The URL defined in your routes
        type: 'GET',
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
        },
        success: function(response) {                   
            setTimeout(() => {
                $(".no-record-inv-search").css('display','block');
                $("#invoicePaymentsTable").html(response)                            
                $(".no-record-inv-search-loader").css('display','none');

            }, 700);
        },
        error: function(xhr, status, error) {
            $(".no-record-inv-search-loader").css('display','none');
            alert(error.message)
        }
    });
    
}

function calcDue(){
    let invoice_total = parseFloat($("#inv_total").html());
    let dueTotal = parseFloat($("#dueTotal").html());
    let paid_total = parseFloat($("#paid_total").val());
    
    let due = (invoice_total+dueTotal) - paid_total;
    
    $("#dueTotal").html(due.toFixed(2))
}

function confirmInvRecord(){
    let dueTotal = parseFloat($("#dueTotal").html());
    let customerid = $(`#cnfBtn`).data("customerid");
    let invoiceid = $(`#cnfBtn`).data("customerid");
    let paid_total = parseFloat($("#paid_total").val());

    let updateUrl = '{{ url('paymentsUpdate') }}/'+customerid  
    $.ajax({
        url: updateUrl,  // The URL defined in your routes
        type: 'POST',
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // CSRF Token
        },
        dataType: 'json',
        data: { due:dueTotal,isBeatCustomer:0,invoiceid:invoiceid,paid_total:paid_total,customerid:customerid },
        success: function(response) {
            if(response.success){
                alert(response.message)
                location.reload();
                }
            else if(!response.success){
                alert(response.message)
            }
        },
        error: function(xhr, status, error) {
            alert(error.message)
        }
    });

}
</script>


