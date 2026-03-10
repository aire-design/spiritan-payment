<p>Dear Parent/Guardian,</p>

<p>Your payment to <strong>Spiritan International Girls' School</strong> has been confirmed successfully.</p>

<ul>
    <li><strong>Student:</strong> {{ $payment->student_full_name }}</li>
    <li><strong>Admission Number:</strong> {{ $payment->admission_number }}</li>
    <li><strong>Payment Purpose:</strong> {{ $payment->payment_purpose }}</li>
    <li><strong>Amount:</strong> ₦{{ number_format($payment->amount_paid, 2) }}</li>
    <li><strong>Transaction Ref:</strong> {{ $payment->payment_reference }}</li>
</ul>

<p>Your receipt is attached to this email.</p>

<p>Thank you.</p>
