<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Financial Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0b3d91; padding-bottom: 15px; }
        .school-name { font-size: 18px; font-weight: bold; color: #0b3d91; margin-bottom: 5px; }
        .contact-info { font-size: 11px; color: #555; }
        .title { text-align: center; font-size: 16px; font-weight: bold; margin-bottom: 15px; background: #f0f4f8; padding: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #0b3d91; color: white; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .status-success { color: #198754; font-weight: bold; }
        .status-pending { color: #ffc107; font-weight: bold; }
        .status-failed { color: #dc3545; font-weight: bold; }
        .amount { text-align: right; font-weight: bold; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 9px; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <div class="school-name">Spiritan International Girls' School</div>
        <div class="contact-info">Sabon Lugbe, Airport Road, Abuja Nigeria | +234 703 165 8535 | info@spiritan-edu.org</div>
    </div>

    <div class="title">
        Official Financial & Parent Payments Report
        <br><span style="font-size: 10px; font-weight: normal; color: #666;">Generated on {{ now()->format('F j, Y, g:i a') }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">Date</th>
                <th style="width: 20%;">Parent Details</th>
                <th style="width: 20%;">Student / Class</th>
                <th style="width: 20%;">Purpose</th>
                <th style="width: 15%; text-align: right;">Amount (₦)</th>
                <th style="width: 15%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ optional($payment->created_at)->format('Y-m-d') }}</td>
                    <td>
                        {{ $payment->parent_email }}<br>
                        <span style="font-size: 9px; color: #555;">{{ $payment->parent_phone }}</span>
                    </td>
                    <td>
                        {{ $payment->student?->full_name ?? $payment->student_full_name }}<br>
                        <span style="font-size: 9px; color: #555;">{{ $payment->class_name }} • {{ $payment->admission_number }}</span>
                    </td>
                    <td>
                        {{ current(explode('-', $payment->fee?->name ?? $payment->payment_type)) }}<br>
                        <span style="font-size: 9px; color: #555;">{{ $payment->payment_purpose ?: 'Standard' }}</span>
                    </td>
                    <td class="amount">{{ number_format($payment->amount_paid, 2) }}</td>
                    <td style="text-align: center;">
                        <span class="status-{{ $payment->status }}">
                            {{ strtoupper($payment->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px;">No payment records found within the selected criteria.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table style="width: 30%; margin-left: auto;">
        <tr>
            <th style="background-color: #eee; color: #333; text-align: left;">Total Amount:</th>
            <td class="amount" style="font-size: 14px; font-weight: bold; background-color: #eef2ff;">
                ₦{{ number_format($payments->where('status', 'success')->sum('amount_paid'), 2) }}
            </td>
        </tr>
    </table>

    <div class="footer">
        Spiritan Digital Financial Management System • Official Record
    </div>

</body>
</html>
