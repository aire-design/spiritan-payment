@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center g-5 min-vh-75">
        
        <!-- Elegant Information Side -->
        <div class="col-lg-4 d-none d-lg-block animate__animated animate__fadeInLeft">
            <div class="pe-4">
                <div class="badge rounded-pill mb-3 px-3 py-2" style="background: var(--md-tertiary-container); color: var(--md-on-tertiary-container); font-family: 'Outfit'; font-weight: 500;">
                    Secure Checkout
                </div>
                <h1 class="display-6 fw-bold mb-4" style="font-family: 'Outfit'; color: var(--md-on-surface);">Make a Payment</h1>
                <p class="mb-5 text-secondary" style="font-size: 1.1rem; line-height: 1.6;">
                    Easily complete school fee payments online. All transactions are encrypted and secured by Paystack.
                </p>
                
                <div class="d-flex flex-column gap-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: #eef2ff; color: var(--md-primary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shield-lock" viewBox="0 0 16 16"><path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.294.118a.616.616 0 0 0 .1.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.531.43 8.527.18 8 0c-.528.18-1.531.43-2.618.724zM8 10.5c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3zm0-5a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/></svg>
                        </div>
                        <span class="text-secondary fw-medium">Bank-level Security</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-circle" style="background: #fbf0ff; color: var(--md-tertiary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope-check" viewBox="0 0 16 16"><path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z"/><path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686Z"/></svg>
                        </div>
                        <span class="text-secondary fw-medium">Instant E-Receipts</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Elegant Form Side -->
        <div class="col-lg-8 animate__animated animate__fadeInRight">
            <div class="card md-card border-0 p-4 p-md-5">
                <div class="text-center mb-4 d-lg-none">
                    <img src="{{ asset('logo.png') }}" height="50" class="mb-3" alt="Logo">
                    <h2 class="fw-bold" style="font-family: 'Outfit';">Make a Payment</h2>
                </div>
                
                <h3 class="mb-4 fw-bold d-none d-lg-block" style="font-family: 'Outfit'; color: var(--md-primary);">Payment Details</h3>
                
                {{-- Smart Parent Info Banner --}}
                @if($authParent && $parentStudents->count() > 0)
                    <div class="alert px-4 py-3 border-0 mb-4" style="background:#e8f0fe; border-radius:12px;">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="fw-bold mb-0 text-primary" style="font-family:'Outfit';">Logged in as {{ $authParent->first_name }}</h6>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-secondary small text-decoration-none">Not you?</a>
                        </div>
                        <p class="mb-2 text-secondary small">Select a child from your registered students to auto-fill the form.</p>
                        
                        <label class="form-label fw-bold text-primary text-uppercase" style="font-size:0.8rem;">Select Child</label>
                        <select class="form-select elegant-input border-primary bg-white" id="parentChildSelect" onchange="applySmartFill()">
                            <option value="" selected disabled>-- Select Your Child --</option>
                            @foreach($parentStudents as $child)
                                <option value="{{ $child->id }}" 
                                    data-name="{{ $child->full_name }}" 
                                    data-admission="{{ $child->admission_number }}" 
                                    data-class-id="{{ $child->school_class_id }}">
                                    {{ $child->full_name }} ({{ $child->schoolClass?->name ?? 'No Class' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                @endif
                
                @if(!Auth::check())
                    <div class="alert alert-light border d-flex align-items-center mb-4" style="border-radius:10px;">
                        <i class="bi bi-info-circle-fill text-primary me-3 fs-5"></i>
                        <span class="text-secondary small">
                            Have an account? <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-none">Log in</a> for a faster checkout.
                        </span>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('pay.store') }}">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="studentNameInput" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">Student Full Name</label>
                            <input type="text" class="form-control elegant-input" id="studentNameInput" name="student_full_name" placeholder="John Doe" required @if(!$authParent) readonly @endif>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="admissionNumberInput" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">Admission Number</label>
                            <input type="text" class="form-control elegant-input" id="admissionNumberInput" name="admission_number" placeholder="SPT/202X/..." required @if(!$authParent) readonly @endif>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="parentEmailInput" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">Parent Email</label>
                            <input type="email" class="form-control elegant-input" id="parentEmailInput" name="parent_email" placeholder="name@example.com" 
                                value="{{ $authParent ? $authParent->email : old('parent_email') }}" required @if($authParent) readonly @endif>
                        </div>

                        <div class="col-md-6">
                            <label for="parentPhoneInput" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">Parent Phone Number</label>
                            <input type="text" class="form-control elegant-input" id="parentPhoneInput" name="parent_phone" placeholder="080..." 
                                value="{{ $authParent ? $authParent->phone : old('parent_phone') }}" required @if($authParent) readonly @endif>
                        </div>
                        
                        <hr class="text-muted my-4">
                        <h5 class="fw-bold mb-3" style="font-family: 'Outfit'; color: var(--md-on-surface);">Fee Selection</h5>

                        <div class="col-md-6">
                            <label for="classSelect" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">Class / Grade</label>
                            <select class="form-select elegant-input fee-trigger" id="classSelect" name="class_name" required>
                                <option value="" selected disabled>Select Class/Grade...</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->name }}" data-id="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="termSelect" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">Term / Session</label>
                            <select class="form-select elegant-input fee-trigger" id="termSelect" required>
                                <option value="" selected disabled>Select Term...</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term->id }}">{{ $term->name }} ({{ $term->academicSession->name }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Only show dynamic student select if anonymous --}}
                        <div class="col-md-12 @if($authParent) d-none @endif">
                            <label for="studentSelect" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">Student Lookup</label>
                            <select class="form-select elegant-input fee-trigger" id="studentSelect" @if(!$authParent) required disabled @endif>
                                <option value="" selected disabled>Select Student...</option>
                            </select>
                        </div>

                        <div class="col-md-12 d-none">
                            <label for="purposeSelect" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">Payment Purpose</label>
                            <select class="form-select elegant-input fee-trigger" id="purposeSelect" required>
                                @foreach($purposes as $purpose)
                                    <option value="{{ $purpose->name }}" {{ str_contains(strtolower($purpose->name), 'fee') ? 'selected' : '' }}>{{ $purpose->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <input type="hidden" name="fee_id" id="hiddenFeeId" required>

                        <div class="col-md-12 mt-4">
                            <div class="alert alert-info d-none" id="feeLookupLoading">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div> Look up fee amount...
                            </div>
                            <div class="alert alert-danger d-none" id="feeLookupError">
                                No fee configured for this selection. Please contact the administrator.
                            </div>
                            
                            <div class="card mb-3 d-none border-primary" id="feeBreakdownCard">
                                <div class="card-header bg-primary text-white py-2">
                                    <h6 class="mb-0 fw-bold"><i class="bi bi-receipt me-2"></i>Fee Breakdown</h6>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush" id="feeBreakdownList">
                                        <!-- Items injected here by JS -->
                                    </ul>
                                </div>
                            </div>

                            <div id="amountContainer">
                                <label for="amountInput" class="form-label fw-bold text-secondary text-uppercase" style="font-size: 0.85rem;">Amount Required (₦)</label>
                                <input type="number" step="0.01" class="form-control elegant-input fw-bold fs-4 text-success" id="amountInput" name="amount" placeholder="0.00" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" id="submitBtn" class="btn btn-lg btn-md-primary w-100 py-3 fs-5 shadow-sm mt-3 d-flex align-items-center justify-content-center gap-2" disabled>
                        <i class="bi bi-credit-card me-1"></i> Proceed to Secure Checkout
                    </button>
                    
                    <div class="text-center mt-4">
                        <img src="https://js.paystack.co/v1/inline/images/paystack.png" style="height: 30px; opacity: 0.8;" alt="Secured by Paystack">
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

<script>
    // Parent Smart Fill Function
    function applySmartFill() {
        const select = document.getElementById('parentChildSelect');
        const selectedOption = select.options[select.selectedIndex];
        
        if (!selectedOption.value) return;

        // Auto-fill student fields
        document.getElementById('studentNameInput').value = selectedOption.getAttribute('data-name');
        document.getElementById('admissionNumberInput').value = selectedOption.getAttribute('data-admission');
        document.getElementById('studentNameInput').readOnly = true;
        document.getElementById('admissionNumberInput').readOnly = true;

        // Auto-select class
        const targetClassId = selectedOption.getAttribute('data-class-id');
        const classSelect = document.getElementById('classSelect');
        
        for (let i = 0; i < classSelect.options.length; i++) {
            if (classSelect.options[i].getAttribute('data-id') == targetClassId) {
                classSelect.selectedIndex = i;
                // Once found, we assume the student dropdown matches logic
                document.getElementById('studentSelect').value = 'dummy_auth_fill'; 
                break;
            }
        }
        
        // Lock class selection so parent doesn't change it by accident
        classSelect.style.pointerEvents = 'none';
        classSelect.style.backgroundColor = '#e9ecef';

        // Trigger fee lookup
        if (typeof window.checkAndLookupFee === 'function') {
            window.checkAndLookupFee();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const classSelect = document.getElementById('classSelect');
        const termSelect = document.getElementById('termSelect');
        const studentSelect = document.getElementById('studentSelect');
        const purposeSelect = document.getElementById('purposeSelect');
        
        const studentNameInput = document.getElementById('studentNameInput');
        const admissionNumberInput = document.getElementById('admissionNumberInput');
        
        const hiddenFeeId = document.getElementById('hiddenFeeId');
        const amountInput = document.getElementById('amountInput');
        
        const loadingBox = document.getElementById('feeLookupLoading');
        const errorBox = document.getElementById('feeLookupError');
        const submitBtn = document.getElementById('submitBtn');
        const breakdownCard = document.getElementById('feeBreakdownCard');
        const breakdownList = document.getElementById('feeBreakdownList');
        
        const isAuthParent = {{ $authParent ? 'true' : 'false' }};

        let studentsData = {};

        const formatter = new Intl.NumberFormat('en-NG', {
            style: 'currency',
            currency: 'NGN',
        });

        // Ensure any purpose containing 'fee' is selected programmatically
        let feeSelected = false;
        Array.from(purposeSelect.options).forEach(opt => {
            const val = opt.value.toLowerCase();
            if(val.includes('fee')) {
                opt.selected = true;
                feeSelected = true;
            }
        });
        
        if (!feeSelected && purposeSelect.options.length > 0) {
            purposeSelect.selectedIndex = 0;
        }

        // Only do public student loading if NOT auth parent
        if (!isAuthParent) {
            classSelect.addEventListener('change', function() {
                const classId = this.options[this.selectedIndex].getAttribute('data-id');
                studentSelect.innerHTML = '<option value="" selected disabled>Loading students...</option>';
                studentSelect.disabled = true;
                studentNameInput.value = '';
                admissionNumberInput.value = '';

                fetch(`{{ route('pay.studentsByClass') }}?class_id=${encodeURIComponent(classId)}`)
                    .then(response => response.json())
                    .then(data => {
                        studentSelect.innerHTML = '<option value="" selected disabled>Select Student</option>';
                        if(data.success && data.students.length > 0) {
                            data.students.forEach(student => {
                                studentsData[student.id] = student;
                                studentSelect.innerHTML += `<option value="${student.id}">${student.name} (${student.admission_number})</option>`;
                            });
                            studentSelect.disabled = false;
                        } else {
                            studentSelect.innerHTML = '<option value="" selected disabled>No active students in this class</option>';
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        studentSelect.innerHTML = '<option value="" selected disabled>Error loading students</option>';
                    });
            });

            studentSelect.addEventListener('change', function() {
                const studentId = this.value;
                if (studentId && studentsData[studentId]) {
                    const student = studentsData[studentId];
                    studentNameInput.value = student.name;
                    admissionNumberInput.value = student.admission_number;
                }
                checkAndLookupFee();
            });
        }

        const triggers = document.querySelectorAll('.fee-trigger');
        triggers.forEach(trigger => {
            if (trigger !== classSelect && trigger !== studentSelect) {
               trigger.addEventListener('change', checkAndLookupFee);
            }
        });

        // Export to global for the smart fill function
        window.checkAndLookupFee = function checkAndLookupFee() {
            // Reset state
            hiddenFeeId.value = '';
            amountInput.value = '';
            submitBtn.disabled = true;
            errorBox.classList.add('d-none');
            loadingBox.classList.add('d-none');
            breakdownCard.classList.add('d-none');
            breakdownList.innerHTML = '';
            amountInput.readOnly = true;

            const selectedClassId = classSelect.options[classSelect.selectedIndex]?.getAttribute('data-id');
            const selectedTerm = termSelect.value;
            const selectedPurpose = purposeSelect.value; 
            
            // Check readiness based on auth mode
            const isReady = isAuthParent 
                ? (selectedClassId && selectedTerm && studentNameInput.value) 
                : (selectedClassId && selectedTerm && studentSelect.value && studentNameInput.value);

            if (isReady && selectedPurpose) {
                loadingBox.classList.remove('d-none');
                
                // Fetch the fee
                fetch(`{{ route('pay.feeLookup') }}?class_id=${encodeURIComponent(selectedClassId)}&term_id=${encodeURIComponent(selectedTerm)}&purpose=${encodeURIComponent(selectedPurpose)}`)
                    .then(response => response.json())
                    .then(data => {
                        loadingBox.classList.add('d-none');
                        
                        if (data.success) {
                            hiddenFeeId.value = data.fee_id;
                            
                            if (data.is_variable) {
                                amountInput.readOnly = false;
                                amountInput.placeholder = "Enter amount to pay";
                            } else {
                                amountInput.value = data.amount;
                            }

                            if (data.items && data.items.length > 0) {
                                let itemsHtml = '';
                                data.items.forEach(item => {
                                    itemsHtml += `
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-2">
                                        <span class="text-secondary">${item.name}</span>
                                        <span class="fw-bold">${formatter.format(item.amount)}</span>
                                    </li>`;
                                });
                                breakdownList.innerHTML = itemsHtml;
                                breakdownCard.classList.remove('d-none');
                            }
                            
                            submitBtn.disabled = false;
                        } else {
                            errorBox.classList.remove('d-none');
                            errorBox.textContent = data.message || "Fee configuration omitted.";
                        }
                    })
                    .catch(err => {
                        loadingBox.classList.add('d-none');
                        errorBox.classList.remove('d-none');
                        errorBox.textContent = 'A network error occurred while looking up fee.';
                        console.error(err);
                    });
            }
        }
    });
</script>

<style>
    .min-vh-75 { min-height: 75vh; }
    .elegant-input {
        border-radius: 8px;
        border: 1px solid #ced4da;
        background-color: #f8f9fa;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }
    .elegant-input:focus {
        border-color: var(--md-primary);
        box-shadow: 0 0 0 4px var(--md-primary-container);
        background-color: #ffffff;
    }
    .form-label {
        letter-spacing: 0.5px;
        margin-bottom: 0.4rem;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection
