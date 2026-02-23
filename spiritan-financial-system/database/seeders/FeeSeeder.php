<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $session = \App\Models\AcademicSession::first();
        $term = \App\Models\Term::first();
        $class = \App\Models\SchoolClass::first();

        if (!$session || !$term) {
            return;
        }

        $fees = [
            [
                'name' => 'First Term Tuition Fee 2025/2026',
                'category' => 'Tuition',
                'school_class_id' => $class?->id,
                'academic_session_id' => $session->id,
                'term_id' => $term->id,
                'amount' => 350000,
                'is_variable' => false,
                'due_date' => \Carbon\Carbon::parse('2025-09-30'),
                'is_active' => true,
            ],
            [
                'name' => 'Hostel Accommodation Fee',
                'category' => 'Boarding',
                'school_class_id' => null,
                'academic_session_id' => $session->id,
                'term_id' => $term->id,
                'amount' => 150000,
                'is_variable' => false,
                'due_date' => \Carbon\Carbon::parse('2025-09-30'),
                'is_active' => true,
            ],
            [
                'name' => 'PTA Levy',
                'category' => 'Levy',
                'school_class_id' => null,
                'academic_session_id' => $session->id,
                'term_id' => $term->id,
                'amount' => 20000,
                'is_variable' => false,
                'due_date' => \Carbon\Carbon::parse('2025-10-15'),
                'is_active' => true,
            ],
            [
                'name' => 'Medical Fee',
                'category' => 'Medical',
                'school_class_id' => null,
                'academic_session_id' => $session->id,
                'term_id' => $term->id,
                'amount' => 10000,
                'is_variable' => false,
                'due_date' => \Carbon\Carbon::parse('2025-09-30'),
                'is_active' => true,
            ],
            [
                'name' => 'Miscellaneous/Optional Fees',
                'category' => 'Miscellaneous',
                'school_class_id' => null,
                'academic_session_id' => $session->id,
                'term_id' => $term->id,
                'amount' => 0,
                'is_variable' => true,
                'due_date' => null,
                'is_active' => true,
            ],
        ];

        foreach ($fees as $fee) {
            \App\Models\Fee::firstOrCreate(
                ['name' => $fee['name'], 'academic_session_id' => $fee['academic_session_id']],
                $fee
            );
        }
    }
}
