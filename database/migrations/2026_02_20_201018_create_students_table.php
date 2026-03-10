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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('admission_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('other_name')->nullable();
            $table->foreignId('school_class_id')->constrained('school_classes')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('academic_session_id')->nullable()->constrained()->nullOnDelete();
            $table->string('parent_name');
            $table->string('parent_phone', 25);
            $table->string('parent_email')->nullable();
            $table->enum('status', ['active', 'inactive', 'graduated'])->default('active');
            $table->decimal('outstanding_balance', 12, 2)->default(0);
            $table->timestamps();

            $table->index(['school_class_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
