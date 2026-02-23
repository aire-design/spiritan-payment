<?php

namespace Database\Seeders;

use App\Models\AcademicSession;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Term;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Payment::query()->delete();
        Fee::query()->delete();
        Student::query()->delete();
        Term::query()->delete();
        AcademicSession::query()->delete();
        SchoolClass::query()->delete();
        User::query()->delete();

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@spiritan.local',
            'role' => 'super_admin',
        ]);

        User::factory()->create([
            'name' => 'Bursar User',
            'email' => 'bursar@spiritan.local',
            'role' => 'bursar',
        ]);

        User::factory()->create([
            'name' => 'Principal User',
            'email' => 'principal@spiritan.local',
            'role' => 'principal',
        ]);

        $class = SchoolClass::create([
            'name' => 'JSS 1',
            'level' => 'Secondary',
            'is_active' => true,
        ]);

        $session = AcademicSession::create([
            'name' => '2025/2026',
            'starts_at' => '2025-09-01',
            'ends_at' => '2026-07-31',
            'is_locked' => false,
        ]);

        $term = Term::create([
            'academic_session_id' => $session->id,
            'name' => 'First Term',
            'starts_at' => '2025-09-01',
            'ends_at' => '2025-12-15',
            'is_locked' => false,
        ]);

        $student = Student::create([
            'admission_number' => 'SPG-001',
            'first_name' => 'Ada',
            'last_name' => 'Okafor',
            'school_class_id' => $class->id,
            'academic_session_id' => $session->id,
            'parent_name' => 'Mr Okafor',
            'parent_phone' => '08030000000',
            'parent_email' => 'parent@example.com',
            'status' => 'active',
            'outstanding_balance' => 350000,
        ]);

        $fee = Fee::create([
            'name' => 'Tuition Fee',
            'category' => 'Tuition',
            'school_class_id' => $class->id,
            'academic_session_id' => $session->id,
            'term_id' => $term->id,
            'amount' => 350000,
            'is_variable' => false,
            'late_fee_penalty' => 10000,
            'due_date' => '2025-10-15',
            'is_active' => true,
        ]);

        Payment::create([
            'student_id' => $student->id,
            'fee_id' => $fee->id,
            'academic_session_id' => $session->id,
            'term_id' => $term->id,
            'amount_paid' => 100000,
            'discount_amount' => 0,
            'late_fee_applied' => 0,
            'balance_after' => 250000,
            'payment_reference' => 'SPT-SEED-0001',
            'payment_method' => 'cash',
            'channel' => 'cash',
            'status' => 'success',
            'paid_at' => now(),
            'receipt_number' => 'RCT-SEED-0001',
            'payer_email' => 'parent@example.com',
            'metadata' => ['seed' => true],
        ]);
    }
}
