@forelse ($invoices as $invoice)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $invoice->invoice_no }}</td>
        <td>{{ $invoice->customer->brauser_name ?? '-' }}</td>
        <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</td>
        <td>₹{{ number_format($invoice->total_amount, 2) }}</td>
        <td>{{ $invoice->round_off ?? '0.00' }}</td>
        <td>{{ $invoice->bank_name ?? '-' }}</td>
        <td>{{ $invoice->ifsc_code ?? '-' }}</td>
        <td>{{ $invoice->created_at?->format('d M, Y') }}</td>
        <td class="text-center">
            {{-- ✅ This wrapper will force the buttons into a single line --}}
            <div class="btn-group btn-group-sm se-2" role="group" aria-label="Invoice Actions">
                <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="btn btn-outline-secondary" title="View">
                    <i class="ri-eye-line"></i>
                </a>
                <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="btn btn-outline-primary" title="Edit">
                    <i class="ri-edit-line"></i>
                </a>
                <button type="button" class="btn btn-outline-danger delete-invoice-btn" data-id="{{ $invoice->id }}"
                    data-name="{{ $invoice->invoice_no }}" title="Delete">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="10" class="text-center text-muted">No invoices found.</td>
    </tr>
@endforelse