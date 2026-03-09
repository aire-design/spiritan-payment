@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-spiritan mb-0">Add Fee</h3>
        <a href="{{ route('fees.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>

    <div class="card p-4">
        <form method="POST" action="{{ route('fees.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Name</label><input class="form-control" name="name" required></div>
                <div class="col-md-6"><label class="form-label">Category</label><input class="form-control" name="category" required></div>
                <div class="col-md-6">
                    <label class="form-label">Amount / Fee Items</label>
                    <div id="feeItemsContainer">
                        <div class="input-group mb-2 fee-item-row">
                            <input type="text" class="form-control" name="item_name[]" placeholder="Item Name (e.g. Tuition)">
                            <input type="number" step="0.01" class="form-control item-amount" name="item_amount[]" placeholder="Amount" oninput="calculateTotal()">
                            <button type="button" class="btn btn-outline-danger remove-item" onclick="removeItem(this)">X</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary mb-2" onclick="addFeeItem()">+ Add Item</button>
                    
                    <div class="input-group">
                        <span class="input-group-text fw-bold">Total Amount</span>
                        <input class="form-control bg-light fw-bold" type="number" step="0.01" name="amount" id="totalAmountInput" readonly required>
                    </div>
                    <small class="text-muted">Will be auto-calculated if items exist. For variable fees, just enter a single item or leave items blank and use total.</small>
                    
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="is_variable" id="isVariableCheck" value="1">
                        <label class="form-check-label" for="isVariableCheck">
                            Is Variable Fee? (Parent enters amount)
                        </label>
                    </div>
                </div>                <div class="col-md-6">
                    <label class="form-label">Class</label>
                    <select class="form-select" name="school_class_id">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Session</label>
                    <select class="form-select" name="academic_session_id" required>
                        @foreach($sessions as $session)
                            <option value="{{ $session->id }}">{{ $session->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Term</label>
                    <select class="form-select" name="term_id">
                        <option value="">Not Term-specific</option>
                        @foreach($terms as $term)
                            <option value="{{ $term->id }}">{{ $term->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6"><label class="form-label">Due Date</label><input class="form-control" type="date" name="due_date"></div>
                <div class="col-md-6"><label class="form-label">Late Fee Penalty</label><input class="form-control" type="number" step="0.01" name="late_fee_penalty" value="0"></div>
            </div>
            <button class="btn btn-spiritan mt-4" type="submit">Save Fee</button>
        </form>
    </div>

    <script>
        function addFeeItem() {
            const container = document.getElementById('feeItemsContainer');
            const row = document.createElement('div');
            row.className = 'input-group mb-2 fee-item-row';
            row.innerHTML = `
                <input type="text" class="form-control" name="item_name[]" placeholder="Item Name">
                <input type="number" step="0.01" class="form-control item-amount" name="item_amount[]" placeholder="Amount" oninput="calculateTotal()">
                <button type="button" class="btn btn-outline-danger remove-item" onclick="removeItem(this)">X</button>
            `;
            container.appendChild(row);
        }

        function removeItem(btn) {
            btn.closest('.fee-item-row').remove();
            calculateTotal();
        }

        function calculateTotal() {
            const amounts = document.querySelectorAll('.item-amount');
            const isVariable = document.getElementById('isVariableCheck').checked;
            const totalInput = document.getElementById('totalAmountInput');
            
            if (isVariable) {
                totalInput.value = '';
                totalInput.readOnly = false;
                return;
            }

            let total = 0;
            let hasItems = false;
            amounts.forEach(input => {
                if (input.value) {
                    hasItems = true;
                    total += parseFloat(input.value) || 0;
                }
            });
            
            if (hasItems) {
                totalInput.value = total.toFixed(2);
                totalInput.readOnly = true;
            } else {
                totalInput.readOnly = false;
            }
        }

        document.getElementById('isVariableCheck').addEventListener('change', calculateTotal);
        
        // Ensure total is calculated on load if form repaints with old values
        document.addEventListener('DOMContentLoaded', calculateTotal);
    </script>
@endsection
