@forelse($customers as $key => $customer)
    <tr>
        <td>{{ $key + 1 }}</td>

        <td>{{ $customer->full_name }}</td>

        <td>{{ $customer->email }}</td>
        <td>{{ $customer->phone ?? 'N/A' }}</td>

        <td>
            @php
                $status = 'Active';
                $badge = 'success';

                if (isset($customer->is_active)) {
                    if ($customer->is_active == 1) {
                        $status = 'Active';
                        $badge = 'success';
                    } elseif ($customer->is_active == 0) {
                        $status = 'Inactive';
                        $badge = 'danger';
                    }
                }
            @endphp

            <span class="badge bg-{{ $badge }} badge-sm">
                {{ $status }}
            </span>
        </td>

        <td>{{ $customer->created_at ? $customer->created_at->format('M d, Y') : 'N/A' }}</td>

        <td>
            <div class="d-flex justify-content-center btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-danger btn-sm delete-item" data-id="{{ $customer->id }}"
                    data-name="{{ $customer->full_name }}" data-type="customer"
                    data-url="{{ route('admin.customers.destroy', $customer->id) }}" title="Delete">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center text-muted">No customers found.</td>
    </tr>
@endforelse