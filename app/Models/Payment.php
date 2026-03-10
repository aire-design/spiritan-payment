<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'student_full_name',
        'admission_number',
        'class_name',
        'fee_id',
        'academic_session_id',
        'term_id',
        'recorded_by',
        'amount_paid',
        'discount_amount',
        'late_fee_applied',
        'balance_after',
        'payment_reference',
        'gateway_reference',
        'payment_method',
        'payment_type',
        'payment_purpose',
        'channel',
        'status',
        'paid_at',
        'verified_at',
        'receipt_number',
        'payer_email',
        'parent_phone',
        'metadata',
        'gateway_payload',
    ];

    protected function casts(): array
    {
        return [
            'amount_paid' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'late_fee_applied' => 'decimal:2',
            'balance_after' => 'decimal:2',
            'metadata' => 'array',
            'gateway_payload' => 'array',
            'paid_at' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function fee(): BelongsTo
    {
        return $this->belongsTo(Fee::class);
    }

    public function academicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(PaymentLog::class);
    }
}
