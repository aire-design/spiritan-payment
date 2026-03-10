<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_session_id')->constrained()->cascadeOnDelete();
            $table->foreignId('term_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('amount_paid', 12, 2);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('late_fee_applied', 12, 2)->default(0);
            $table->decimal('balance_after', 12, 2)->default(0);
            $table->string('payment_reference')->unique();
            $table->string('gateway_reference')->nullable()->unique();
            $table->enum('payment_method', ['paystack', 'cash', 'bank_transfer', 'pos'])->default('paystack');
            $table->string('channel')->nullable();
            $table->enum('status', ['pending', 'success', 'failed', 'reversed'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->string('receipt_number')->nullable()->unique();
            $table->string('payer_email')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['student_id', 'status']);
            $table->index(['academic_session_id', 'term_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
