@forelse ($invoices as $invoice)
    <tr>

        {{-- Serial Number --}}
        <td class="text-center text-muted">
            {{ ($invoices->currentPage() - 1) * $invoices->perPage() + $loop->iteration }}
        </td>

        {{-- Invoice Number (Used for JS Delete prompt) --}}
        <td class="fw-bold text-dark">{{ $invoice->invoice_no }}</td>

        {{-- Customer --}}
        <td>
            <div class="d-flex align-items-center">
                <div class="avatar-xs bg-light rounded-circle text-primary d-flex align-items-center justify-content-center me-2"
                    style="width: 24px; height: 24px;">
                    <i class="ri-user-line fs-6"></i>
                </div>
                <span class="text-nowrap">{{ $invoice->customer->brauser_name ?? 'N/A' }}</span>
            </div>
        </td>

        {{-- Invoice Date --}}
        <td class="text-nowrap">
            {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}
        </td>

        {{-- Status (Assuming status logic is correct) --}}
        <td class="text-center">
            @php
                $status = strtolower($invoice->status ?? 'pending');
                $colors = [
                    'paid' => 'success',
                    'overdue' => 'danger',
                    'pending' => 'warning'
                ];
                $color = $colors[$status] ?? 'warning';
            @endphp

            <span class="badge bg-{{ $color }} bg-opacity-10 text-{{ $color }} px-2 py-1 rounded-pill border border-{{ $color }} border-opacity-25">
                {{ ucfirst($invoice->status ?? 'Pending') }}
            </span>
        </td>

        {{-- Total --}}
        <td class="fw-medium text-dark text-end">
            ₹{{ number_format($invoice->total_amount, 2) }}
        </td>

        {{-- Round Off --}}
        <td class="text-muted text-end">
            {{ number_format($invoice->round_off ?? 0, 2) }}
        </td>

        {{-- Bank --}}
        <td>{{ $invoice->bank_name ?? '-' }}</td>

        {{-- Created Date --}}
        <td class="text-muted small text-nowrap">
            {{ $invoice->created_at ? $invoice->created_at->format('d M, Y') : '-' }}
        </td>

        {{-- Actions --}}
        <td class="text-center">
            <div class="btn-group **btn-group-sm**">

                {{-- View --}}
                <a href="{{ route('admin.invoices.show', $invoice->id) }}" 
                   class="btn **btn-sm** btn-outline-secondary" title="View">
                    <i class="ri-eye-line"></i>
                </a>

                {{-- Edit --}}
                <a href="{{ route('admin.invoices.edit', $invoice->id) }}" 
                   class="btn **btn-sm** btn-outline-primary" title="Edit">
                    <i class="ri-edit-line"></i>
                </a>

                {{-- Download --}}
                <a href="{{ route('admin.invoices.download', $invoice->id) }}" 
                   class="btn **btn-sm** btn-outline-success" title="Download PDF">
                    <i class="ri-download-line"></i>
                </a>

                {{-- Delete (Crucial for JS) --}}
                <button type="button"
                        class="btn **btn-sm** btn-outline-danger delete-invoice-btn"
                        data-id="{{ $invoice->id }}"
                        data-invoice-no="{{ $invoice->invoice_no }}"
                        title="Delete">
                    <i class="ri-delete-bin-line"></i>
                </button>

            </div>
        </td>

    </tr>

@empty

    <tr class="no-result">
        <td colspan="10" class="text-center py-5">
            <div class="d-flex flex-column align-items-center text-muted">
                <i class="ri-inbox-line fs-2 mb-2"></i>
                <span>No invoices found.</span>
            </div>
        </td>
    </tr>

@endforelse