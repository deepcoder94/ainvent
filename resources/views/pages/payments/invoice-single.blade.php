@if (!empty($customerpayments))
<tr>
    <td>
        {{ $customerpayments->invoice->invoice_number }}
    </td>
    <td id="inv_total">
        {{ $customerpayments->invoice_total }}        
    </td>
    <td>
        <input type="text" value="0.00" id="paid_total" class="form-control" onblur="calcDue()">                                        
    </td>
    <td id="dueTotal">
        {{ $customerpayments->total_due }}
    </td>
    <td>
        <button
            type="button"
            class="btn btn-success"
            onclick="confirmInvRecord()"
            id="cnfBtn"
            data-customerid="{{ $customerpayments->customer_id }}"
            data-invoiceid="{{ $customerpayments->invoice_id }}"
        >
            <i class="bi bi-check-lg"></i>
        </button>                                        
    </td>
</tr>

@else
<tr class="no-record-inv-search-loader" style="display: none">
    <td class="td-3" colspan="5"><span></span></td>
</tr>

<tr class="no-record-inv-search">
    <td colspan="6" class="text-center">No records found</td>
</tr>

@endif
                                