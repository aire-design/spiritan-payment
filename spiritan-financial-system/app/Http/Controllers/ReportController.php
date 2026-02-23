<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->string('status')->toString();
        $paymentType = $request->string('payment_type')->toString();
        $className = $request->string('class_name')->toString();
        $admissionNumber = $request->string('admission_number')->toString();
        $fromDate = $request->string('from_date')->toString();
        $toDate = $request->string('to_date')->toString();

        $paymentsQuery = Payment::with(['student', 'fee'])->latest();

        if ($status !== '') {
            $paymentsQuery->where('status', $status);
        }

        if ($paymentType !== '') {
            $paymentsQuery->where('payment_type', $paymentType);
        }

        if ($className !== '') {
            $paymentsQuery->where('class_name', $className);
        }

        if ($admissionNumber !== '') {
            $paymentsQuery->where('admission_number', $admissionNumber);
        }

        if ($fromDate !== '') {
            $paymentsQuery->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate !== '') {
            $paymentsQuery->whereDate('created_at', '<=', $toDate);
        }

        $payments = $paymentsQuery->paginate(30)->withQueryString();
        $paymentTypes = Payment::query()->whereNotNull('payment_type')->distinct()->pluck('payment_type');
        $classes = SchoolClass::query()->where('is_active', true)->pluck('name');
        $purposes = \App\Models\PaymentPurpose::query()->where('is_active', true)->get();

        $summary = [
            'total_paid' => Payment::where('status', 'success')->sum('amount_paid'),
            'pending_transactions' => Payment::where('status', 'pending')->count(),
            'failed_transactions' => Payment::where('status', 'failed')->count(),
            'outstanding_total' => Student::sum('outstanding_balance'),
        ];

        return view('reports.index', compact(
            'payments',
            'summary',
            'status',
            'paymentTypes',
            'classes',
            'purposes',
            'paymentType',
            'className',
            'admissionNumber',
            'fromDate',
            'toDate',
        ));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $payments = Payment::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->when($request->filled('payment_type'), fn ($q) => $q->where('payment_type', $request->string('payment_type')->toString()))
            ->when($request->filled('class_name'), fn ($q) => $q->where('class_name', $request->string('class_name')->toString()))
            ->when($request->filled('admission_number'), fn ($q) => $q->where('admission_number', $request->string('admission_number')->toString()))
            ->when($request->filled('from_date'), fn ($q) => $q->whereDate('created_at', '>=', $request->string('from_date')->toString()))
            ->when($request->filled('to_date'), fn ($q) => $q->whereDate('created_at', '<=', $request->string('to_date')->toString()))
            ->latest()
            ->get();

        $filename = 'payments_report_'.now()->format('Ymd_His').'.csv';

        return response()->streamDownload(function () use ($payments) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Reference', 'Student', 'Admission No', 'Class', 'Payment Type', 'Purpose', 'Amount', 'Status', 'Date', 'Parent Email', 'Parent Phone']);

            foreach ($payments as $payment) {
                fputcsv($handle, [
                    $payment->payment_reference,
                    $payment->student_full_name,
                    $payment->admission_number,
                    $payment->class_name,
                    $payment->payment_type,
                    $payment->payment_purpose,
                    $payment->amount_paid,
                    $payment->status,
                    optional($payment->created_at)->format('Y-m-d H:i:s'),
                    $payment->parent_email,
                    $payment->parent_phone,
                ]);
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    public function exportExcel(Request $request): StreamedResponse
    {
        $payments = Payment::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->when($request->filled('payment_type'), fn ($q) => $q->where('payment_type', $request->string('payment_type')->toString()))
            ->when($request->filled('class_name'), fn ($q) => $q->where('class_name', $request->string('class_name')->toString()))
            ->when($request->filled('admission_number'), fn ($q) => $q->where('admission_number', $request->string('admission_number')->toString()))
            ->when($request->filled('from_date'), fn ($q) => $q->whereDate('created_at', '>=', $request->string('from_date')->toString()))
            ->when($request->filled('to_date'), fn ($q) => $q->whereDate('created_at', '<=', $request->string('to_date')->toString()))
            ->latest()
            ->get();

        $filename = 'payments_report_'.now()->format('Ymd_His').'.xls';

        return response()->streamDownload(function () use ($payments) {
            echo "<table border='1'>";
            echo '<tr><th>Reference</th><th>Student</th><th>Admission No</th><th>Class</th><th>Payment Type</th><th>Amount</th><th>Status</th><th>Date</th><th>Parent Email</th><th>Parent Phone</th></tr>';

            foreach ($payments as $payment) {
                echo '<tr>';
                echo '<td>'.e($payment->payment_reference).'</td>';
                echo '<td>'.e($payment->student_full_name).'</td>';
                echo '<td>'.e($payment->admission_number).'</td>';
                echo '<td>'.e($payment->class_name).'</td>';
                echo '<td>'.e($payment->payment_type).'</td>';
                echo '<td>'.e((string) $payment->amount_paid).'</td>';
                echo '<td>'.e($payment->status).'</td>';
                echo '<td>'.e(optional($payment->created_at)->format('Y-m-d H:i:s')).'</td>';
                echo '<td>'.e($payment->parent_email).'</td>';
                echo '<td>'.e($payment->parent_phone).'</td>';
                echo '</tr>';
            }

            echo '</table>';
        }, $filename, ['Content-Type' => 'application/vnd.ms-excel']);
    }

    public function exportPdf(Request $request)
    {
        $payments = Payment::query()
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->when($request->filled('payment_type'), fn ($q) => $q->where('payment_type', $request->string('payment_type')->toString()))
            ->when($request->filled('class_name'), fn ($q) => $q->where('class_name', $request->string('class_name')->toString()))
            ->when($request->filled('admission_number'), fn ($q) => $q->where('admission_number', $request->string('admission_number')->toString()))
            ->when($request->filled('from_date'), fn ($q) => $q->whereDate('created_at', '>=', $request->string('from_date')->toString()))
            ->when($request->filled('to_date'), fn ($q) => $q->whereDate('created_at', '<=', $request->string('to_date')->toString()))
            ->latest()
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', compact('payments'));

        return $pdf->download('payments_report_'.now()->format('Ymd_His').'.pdf');
    }
}
