@if (!empty($customerpayments))
<tr>
    <td>
        {{ $customerpayments['invoice_number'] }}
    </td>
    <td id="inv_total">
        {{ $customerpayments['invoice_total'] }}        
    </td>
    <td>
        <input type="text" value="0.00" id="paid_total" class="form-control" onblur="calcDue()">                                        
    </td>
    <td id="dueTotal">
        0
    </td>
    <td>
        <button
            type="button"
            class="btn btn-success"
            onclick="confirmInvRecord()"
            id="cnfBtn"
            data-customerid="{{ $customerpayments['customer_id'] }}"

        >
            <i class="bi bi-check-lg"></i>
        </button>                                        
    </td>
</tr>

@else
<tr>
    <td colspan="6" class="text-center">No records found</td>
</tr>

@endif
                                