
@forelse ($customerpayments as $customer)
                                <tr>
                                    <td>{{ $customer->customer->customer_name }}</td>
                                    <td>{{ $customer->invoice->invoice_number }}</td>
                                    <td id="inv_total{{ $customer->id }}">{{ $customer->invoice_total }}</td>
                                    <td>
                                        <input type="text" value="0.00" id="paid_total_{{ $customer->id }}" class="form-control" onkeyup="calcDue('{{ $customer->id }}')">                                        
                                    </td>
                                    <td id="dueTotal{{ $customer->id }}">
                                        {{ $customer->total_due }}
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-primary btn_{{ $customer->id}}"
                                            onclick="confirmRecord('{{ $customer->id }}')"
                                            data-invoicetotal="{{ $customer->invoice_total }}"
                                            data-duetotal="{{ $customer->total_due }}"
                                            data-invoiceid="{{ $customer->invoice_id }}"
                                            data-customerid="{{ $customer->customer_id }}"
                                        >
                                        <span class="spinner-border spinner-border-sm visually-hidden status_progress_{{ $customer->id }}" role="status" aria-hidden="true"></span>
                                        <span class="status_pay_{{ $customer->id }}">Pay</span>
                                        <span class="visually-hidden status_paid_{{ $customer->id }}">Paid</span>
                                        </button>                                        
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No records found</td>
                                </tr>
                                @endforelse
                                