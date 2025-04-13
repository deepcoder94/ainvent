@forelse ($products as $product)
<tr>
    <td>{{ $product->id }}</td>
    <td>{{ $product->product_name }}</td>
    <td>{{ $product->product_rate }}</td>
    <td>{{ $product->gst_rate }}</td>

    <td>
        @foreach ($product->measurements as $m)
            <span class="badge bg-primary">{{ $m->name }}</span>            
        @endforeach
    </td>
    <td>{{ $product->product_hsn }}</td>

    <!-- Edit/Delete Buttons (Side by Side on All Screens) -->
    <td class="d-flex flex-row">
        <!-- Edit Button -->
        <button
            type="button"
            class="btn btn-primary btn-sm me-2"
            onclick="showEditForm('{{
                $product
            }}','{{
                url('/updateProductById/')
            }}/{{ $product->id }}')"
        >
            <i
                class="bi bi-pencil-square"
            ></i>
        </button>

        <!-- Delete Button -->
        <button
            type="button"
            class="btn btn-danger btn-sm"
            onclick="showDeleteConfirmationDialog('{{ $product->id }}','{{
                url('/deleteProductById/')
            }}/{{ $product->id }}')"
        >
            <i class="bi bi-trash-fill"></i>
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">
        No records found
    </td>
</tr>
@endforelse
