
@forelse ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    <td>{{ $customer->customer_name }}</td>
                                    <td>{{ $customer->beat->beat_name }}</td>
                                    <td>
                                        {{ $customer->payments->total_due ?? 'NA' }}
                                    </td>
                                    <td>
                                        <span class="badge  {{ $customer->is_active == 1 ? 'bg-success':'bg-danger' }}">{{ $customer->is_active == 1 ? 'Active':'Inactive' }}</span>
                                    </td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-primary"
                                            onclick="showEditForm('{{ $customer }}','{{ url('/updateCustomerById/')}}/{{ $customer->id }}')"
                                            
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-danger"
                                            onclick="showDeleteConfirmationDialog('{{ $customer->id }}','{{ url('/deleteCustomerById/')}}/{{ $customer->id }}')"                                            
                                        >
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No records found</td>
                                </tr>
                                @endforelse
                                