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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('student_full_name')->nullable()->after('student_id');
            $table->string('admission_number')->nullable()->after('student_full_name');
            $table->string('class_name')->nullable()->after('admission_number');
            $table->string('parent_phone', 25)->nullable()->after('payer_email');
            $table->string('payment_type')->nullable()->after('payment_method');
            $table->string('payment_purpose')->nullable()->after('payment_type');
            $table->timestamp('verified_at')->nullable()->after('paid_at');
            $table->json('gateway_payload')->nullable()->after('metadata');

            $table->index('admission_number');
            $table->index('payment_type');
            $table->index('verified_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['admission_number']);
            $table->dropIndex(['payment_type']);
            $table->dropIndex(['verified_at']);

            $table->dropColumn([
                'student_full_name',
                'admission_number',
                'class_name',
                'parent_phone',
                'payment_type',
                'payment_purpose',
                'verified_at',
                'gateway_payload',
            ]);
        });
    }
};
