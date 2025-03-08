
@forelse ($customerpayments as $customer)
                                <tr>
                                    <td>{{ $customer->customer->id }}</td>
                                    <td>{{ $customer->customer->customer_name }}</td>
                                    <td>{{ $customer->invoice_total }}</td>
                                    <td>
                                        <input type="text" value="0.00" id="paid_total_{{ $customer->id }}" class="form-control">                                        
                                    </td>
                                    <td>
                                        {{ $customer->total_due }}
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-success btn_{{ $customer->id}}"
                                            onclick="confirmRecord('{{ $customer->id }}')"
                                            data-invoicetotal="{{ $customer->invoice_total }}"
                                            data-duetotal="{{ $customer->total_due }}"
                                        >
                                            <i class="bi bi-check-lg"></i>
                                        </button>                                        
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No records found</td>
                                </tr>
                                @endforelse
                                