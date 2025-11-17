{{-- This partial is used to render table rows for both initial page load and AJAX refreshes --}}

@forelse ($customers as $index => $customer)
    <tr>
        {{-- Sr. No (calculates correctly with pagination) --}}
        <td>{{ $customers->firstItem() + $index }}</td>
        
        {{-- Borrower Name --}}
        <td class="fw-semibold">{{ $customer->brauser_name ?? '-' }}</td>
        
        {{-- Relative Name --}}
        <td>{{ $customer->ralative_name ?? '-' }}</td>
        
        {{-- Cash Officer --}}
        <td>{{ $customer->cash_incharge ?? '-' }}</td>
        
        {{-- Loan A/C --}}
        <td>{{ $customer->loan_number ?? '-' }}</td>
        
        {{-- Saving A/C --}}
        <td>{{ $customer->saving_number ?? '-' }}</td>
        
        {{-- Bank --}}
        <td>{{ $customer->bank->bank ?? '-' }}</td>

        {{-- Branch --}}
        <td>{{ $customer->branch->branch_address ?? '-' }}</td>
        
        {{-- Ledger Folio No (for second appraisal) --}}
        <td>{{ $customer->ledger_folio_no ?? '-' }}</td>
        
        {{-- Status --}}
        <td>
            @if($customer->is_active)
                <span class="badge bg-success">Active</span>
            @else
                <span class="badge bg-danger">Inactive</span>
            @endif
        </td>
        
        {{-- Joined On (Appraisal Date) --}}
        <td>{{ $customer->date ? \Carbon\Carbon::parse($customer->date)->format('d M, Y') : ($customer->created_at?->format('d M, Y') ?? '-') }}</td>
        
        {{-- Actions --}}
        <td>
            <div class="d-flex justify-content-center gap-1">
                <!-- 👁️ View -->
                <a href="{{ route('admin.customers.show', $customer->id) }}"
                   class="btn btn-sm btn-outline-secondary" title="View">
                    <i class="ri-eye-line"></i>
                </a>

                <!-- ✏️ Edit -->
                <a href="{{ route('admin.customers.edit', $customer->id) }}"
                   class="btn btn-sm btn-outline-primary" title="Edit">
                    <i class="ri-edit-line"></i>
                </a>

              
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="12" class="text-center text-muted py-4">
            <i class="ri-inbox-line fs-2 d-block mb-2"></i>
            No customers found.
        </td>
    </tr>
@endforelse