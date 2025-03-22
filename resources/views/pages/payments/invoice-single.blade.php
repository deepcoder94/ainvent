@if (!empty($customerpayments))
<tr>
    <td>
        {{ $customerpayments->invoice->invoice_number }}
    </td>
    <td id="inv_total">
        {{ $customerpayments->invoice_total }}        
    </td>
    <td>
        <input type="text" value="0.00" id="paid_total" class="form-control" onkeyup="calcDueSingle()">                                        
    </td>
    <td id="dueTotal">
        {{ $customerpayments->total_due }}
    </td>
    <td>
        <button
            type="button"
            class="btn btn-primary"
            onclick="confirmInvRecord()"
            id="cnfBtn"
            data-customerid="{{ $customerpayments->customer_id }}"
            data-invoiceid="{{ $customerpayments->invoice_id }}"
            data-invoicetotal="{{ $customerpayments->invoice_total }}"
            data-duetotal="{{ $customerpayments->total_due }}"
        >
        <span class="spinner-border spinner-border-sm visually-hidden status_progress" role="status" aria-hidden="true"></span>
        <span class="status_pay">Pay</span>
        <span class="visually-hidden status_paid">Paid</span>

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
                                