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

    $(".status_progress_"+customer_id).removeClass('visually-hidden');
    $(".status_pay_"+customer_id).addClass('visually-hidden');
                    
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
                $(".status_progress_"+customer_id).addClass('visually-hidden');
                $(".status_paid_"+customer_id).removeClass('visually-hidden');
                $(".btn_"+customer_id).removeClass('btn-primary').addClass('btn-success');
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

function calcDue(id){
    let invtotal = $(".btn_"+id).data('invoicetotal');
    let duetotal = $(".btn_"+id).data('duetotal');

    let invoice_total = invtotal;
    let dueTotal = duetotal;
    
    let due = duetotal;
    let ptotal = $("#paid_total_"+id).val();
    
    if(ptotal.length > 0){
        let paid_total = parseFloat(ptotal);
        due = dueTotal - paid_total;
    }    
    
    $("#dueTotal"+id).html(due.toFixed(2))
}

function calcDueSingle(){
    let invtotal = $("#cnfBtn").data('invoicetotal');
    let duetotal = $("#cnfBtn").data('duetotal');

    let invoice_total = invtotal;
    let dueTotal = duetotal;
    
    let due = duetotal;
    let ptotal = $("#paid_total").val();
    
    if(ptotal.length > 0){
        let paid_total = parseFloat(ptotal);
        due = dueTotal - paid_total;
    }    
    
    $("#dueTotal").html(due.toFixed(2))

}

function confirmInvRecord(){
    let dueTotal = parseFloat($("#dueTotal").html());
    let customerid = $(`#cnfBtn`).data("customerid");
    let invoiceid = $(`#cnfBtn`).data("invoiceid");
    let paid_total = parseFloat($("#paid_total").val());

    let updateUrl = '{{ url('paymentsUpdate') }}/'+customerid  
    $(".status_progress").removeClass('visually-hidden');
    $(".status_pay").addClass('visually-hidden');

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
                $(".status_progress").addClass('visually-hidden');
                $(".status_paid").removeClass('visually-hidden');
                $("#cnfBtn").removeClass('btn-primary').addClass('btn-success');

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


