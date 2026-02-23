<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Spiritan Payment Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        .header { text-align: center; margin-bottom: 12px; }
        .header h2 { margin: 0; color: #0b3d91; }
        .box { border: 1px solid #ddd; padding: 12px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 6px; border-bottom: 1px solid #eee; }
        .label { width: 35%; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Spiritan International Girls' School</h2>
        <p>Official Payment Receipt</p>
    </div>

    <div class="box">
        <table>
            <tr><td class="label">Student Name</td><td>{{ $payment->student_full_name }}</td></tr>
            <tr><td class="label">Admission Number</td><td>{{ $payment->admission_number }}</td></tr>
            <tr><td class="label">Class</td><td>{{ $payment->class_name }}</td></tr>
            <tr><td class="label">Amount Paid</td><td>₦{{ number_format($payment->amount_paid, 2) }}</td></tr>
            <tr><td class="label">Payment Purpose</td><td>{{ $payment->payment_purpose }}</td></tr>
            <tr><td class="label">Date</td><td>{{ optional($payment->paid_at)->format('d M Y, h:i A') ?? now()->format('d M Y, h:i A') }}</td></tr>
            <tr><td class="label">Transaction Reference</td><td>{{ $payment->payment_reference }}</td></tr>
            <tr><td class="label">Payment Status</td><td>{{ strtoupper($payment->status) }}</td></tr>
        </table>
    </div>
</body>
</html>
