<?php

namespace App\Jobs;

use App\Mail\PaymentConfirmationMail;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendPaymentConfirmationJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(public int $paymentId) {}

    public function handle(): void
    {
        $payment = Payment::with(['fee'])->find($this->paymentId);

        if (! $payment || $payment->status !== 'success' || ! $payment->payer_email) {
            return;
        }

        $pdf = Pdf::loadView('receipts.payment', ['payment' => $payment]);
        $mail = new PaymentConfirmationMail($payment);

        Mail::to($payment->payer_email)
            ->cc(config('mail.accounts_department_email'))
            ->send($mail->attachData($pdf->output(), 'receipt-'.$payment->payment_reference.'.pdf'));
    }
}
